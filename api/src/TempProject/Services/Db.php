<?php 

namespace TempProject\Services;

class Db
{
    /** @var \PDO */
    private $pdo;

    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance(): self 
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
    
    public function query(string $select, string $table, string $orderBy, string $order, int $limit = 3, int $offset, $params = [], string $className = 'stdClass'): ?array
    {
        $sql = "SELECT $select FROM $table ORDER BY $orderBy $order LIMIT $limit OFFSET $offset;";
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }
        $nRows = $this->pdo->query("SELECT count(*) FROM $table;")->fetchColumn(); 
        return ["items" => $sth->fetchAll(\PDO::FETCH_CLASS, $className), "total" => $nRows];
    }

    public function query_old(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        // return $sth->fetchAll();
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

}

?>