<?php

namespace App\Modules\Users\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public string $login;
    public string $name;
    public string $password;
    public string $email;
    public int|null $id;

    public function __construct(...$parameters)
    {
        parent::__construct($parameters);
    }
}