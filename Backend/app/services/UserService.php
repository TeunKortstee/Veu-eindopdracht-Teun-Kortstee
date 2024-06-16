<?php
namespace Services;

use Exception;
use Repositories\UserRepository;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class UserService
{
    private $repository;
    private $jwt_secret;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function isUsernameEmailAvailable($username, $email)
    {
        return $this->repository->isUsernameEmailAvailable($username, $email);
    }

    public function checkUsernamePassword($username, $password)
    {
        return $this->repository->checkUsernamePassword($username, $password);
    }

    public function isUserAdmin($userId)
    {
        return $this->repository->isUserAdmin($userId);
    }

    public function createUser($username, $email, $password)
    {
        $user = new \Models\User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $this->hashPassword($password);

        return $this->repository->insert($user);
    }

    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public function generateToken($user)
    {
        $payload = [
            'iss' => "your_issuer",
            'aud' => "your_audience",
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + (60 * 60), // Token expires in 1 hour
            'data' => [
                'id' => $user['id'],
                'username' => $user['username']
            ]
        ];
        return JWT::encode($payload, $this->jwt_secret, 'HS256');
    }

    public function verifyToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->jwt_secret, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }

}