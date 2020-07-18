<?php

namespace TempProject\Models\Tasks;

use TempProject\Models\ActiveRecordEntity;

class Task extends ActiveRecordEntity
{
     /** @var int */
     public $id;

    /** @var string */
    public $username;

    /** @var string */
    public $text;

    /** @var string */
    public $eMail;

    /** @var string */
    public $createdAt;

    /** @var boolean */
    public $isModered;

    /** @var boolean */
    public $isEdited;
    

    public function setText(string $text): string
    {
        return $this->text = $text;
    }

    public function setUserName(string $username): string
    {
        return $this->username = $username;
    }

    public function setEmail(string $eMail): string
    {
        return $this->eMail = $eMail;
    }

    public function setIsModered(string $isModered): string
    {
        return $this->isModered = $isModered;
    }

    public function getIsModered(): string
    {
        return $this->isModered;
    }

    
    public function setIsEdited(string $isEdited): string
    {
        return $this->isEdited = $isEdited;
    }


    protected static function getTableName(): string 
    {
        return 'tasks';
    }

}