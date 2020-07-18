<?php

namespace TempProject\Models;

use TempProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * 
     * @return static|null
     */
    public static function getByString(string $string, string $by): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query_old(
            'SELECT * FROM `' . static::getTableName() . '` WHERE '.$by.'=:str;',
            [':str' => $string],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }


    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $mappedProperties[$propertyName] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
           return $this->update($mappedProperties);
        } else {
            return $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[':param' . $index] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query_old($sql, $params2values, static::class);

    }

    private function insert(array $mappedProperties)
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName. '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        $db = Db::getInstance();
        $db->query_old($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();

        return true;
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query_old(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * @return static[]
     */
    public static function findAll(int $page, string $order, string $orderBy): array
    {
        $limit = 3;
        $offset = $page * $limit - $limit;
        $db = Db::getInstance();
        $orderType = strtoupper($order);
        // $query = "SELECT * FROM ".static::getTableName()." ORDER BY username $orderType LIMIT $limit OFFSET $offset;";
        return $db->query("*", static::getTableName(), $orderBy, $orderType, $limit, $offset, [], static::class);
    }

    abstract protected static function getTableName(): string;
}


?>