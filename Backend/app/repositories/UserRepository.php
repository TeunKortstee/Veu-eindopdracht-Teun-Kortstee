<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

class UserRepository extends Repository
{
    public function isUsernameEmailAvailable($username, $email)
    {
        try {
            // check if the username or email is already taken
            $stmt = $this->connection->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->rowCount() === 0;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function checkUsernamePassword($username, $password)
    {
        try {
            // retrieve the user with the given username
            $stmt = $this->connection->prepare("SELECT id, username, email, password, is_admin FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            if (!$user)
                return false;

            // verify if the password matches the hash in the database
            $result = $this->verifyPassword($password, $user->password);

            if (!$result)
                return false;

            // do not pass the password hash to the caller
            $user->password = "";

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function isUserAdmin($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT is_admin FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();

            return $row['is_admin'] == 1;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function insert($user)
    {
        try {
            // insert the user into the database
            $stmt = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->execute();

            // Fetch the complete user details with the newly generated ID
            $userId = $this->connection->lastInsertId();
            $stmt = $this->connection->prepare("SELECT id, username, email, is_admin FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            // Return the user object to the caller
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }
}