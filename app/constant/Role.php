<?php
namespace App\constant;
class Role
{
public const ADMIN = 'admin';
public const EMPLOYEE = 'employee';
public const SEEKER = 'seeker';
public const PROVIDER = 'provider';

public function all(){
    return [
        self::ADMIN,
        self::EMPLOYEE,
        self::SEEKER,
        self::PROVIDER
    ];
}
}
