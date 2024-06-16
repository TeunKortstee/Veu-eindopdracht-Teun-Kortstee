<?php
namespace Repositories;

use PDO;
use PDOException;

class Repository
{

    protected $connection;

    function __construct()
    {
        try {
            require __DIR__ . '/../config/dbconfig.php';

            $this->connection = new PDO("$config[type]:host=$config[servername];dbname=$config[database]", $config['username'], $config['password']);

            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}