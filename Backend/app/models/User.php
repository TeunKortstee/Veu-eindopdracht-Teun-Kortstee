<?php
namespace Models;

class User
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public bool $is_admin;
}