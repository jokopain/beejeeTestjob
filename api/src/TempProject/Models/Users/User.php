<?php

namespace TempProject\Models\Users;

use TempProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var int */
   public $id;

   /** @var string */
   public $username;

   /** @var string */
   public $passHash;


   /**
    * @return string
    */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassHash(): string
    {
        return $this->passHash;
    }

    protected static function getTableName(): string
    {
        return 'admins';
    }
}

