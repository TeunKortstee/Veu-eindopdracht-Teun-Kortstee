<?php
namespace Controllers;

use Exception;
use Services\UserService;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login()
    {
        try {
            $data = $this->getPostedJson();

            // Check if username and password are provided
            if (empty($data->username) || empty($data->password)) {
                throw new Exception("Username and password are required.");
            }

            // Conversions
            $data->username = strtolower(trim($data->username));

            // Check username and password against database
            $user = $this->service->checkUsernamePassword($data->username, $data->password);

            if (!$user) {
                throw new Exception("Invalid username or password.");
            }

            // Generate JWT token
            $token = $this->service->generateToken($user);

            // Send token back to the client
            $this->respond(['token' => $token, 'user' => ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'isAdmin' => $user->is_admin]]);
        } catch (Exception $e) {
            $this->respondWithError(400, $e->getMessage());
        }
    }

    public function register()
    {
        try {
            $data = $this->getPostedJson();

            // Check if username, email, and password are provided
            if (empty($data->username) || empty($data->email) || empty($data->password)) {
                throw new Exception("Username, email, and password are required.");
            }

            // Conversions
            $data->username = strtolower(trim($data->username));
            $data->email = strtolower(trim($data->email));

            // Validate username
            if (strlen($data->username) > 16) {
                throw new Exception("Username must be 16 characters or less.");
            }

            if (!preg_match('/^[a-z0-9_]+$/', $data->username)) {
                throw new Exception("Invalid username. Only lowercase alphanumeric characters and underscores are allowed.");
            }

            // Validate email
            if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email.");
            }

            // Validate password
            if (strlen($data->password) < 8 || strlen($data->password) > 64) {
                throw new Exception("Password must be between 8 and 64 characters long.");
            }

            if (
                !preg_match('/[a-z]/', $data->password) ||
                !preg_match('/[A-Z]/', $data->password) ||
                !preg_match('/[0-9]/', $data->password) ||
                !preg_match('/[^a-zA-Z0-9]/', $data->password)
            ) {
                throw new Exception("Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.");
            }

            // Check if username or email already exists
            if (!$this->service->isUsernameEmailAvailable($data->username, $data->email)) {
                throw new Exception("Username or email already exists.");
            }

            // Create user
            $user = $this->service->createUser($data->username, $data->email, $data->password);

            if (!$user) {
                throw new Exception("Failed to create user.");
            }

            // Generate JWT token
            $token = $this->service->generateToken($user);

            // Send token back to the client
            $this->respond(['token' => $token, 'user' => ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'isAdmin' => $user->is_admin]]);
        } catch (Exception $e) {
            $this->respondWithError(400, $e->getMessage());
        }
    }

    public function verifyTokenValidity()
    {
        try {
            $token = $this->getBearerToken();
            if (!$token) {
                $this->respondWithError(400, "Token is required.");
                return;
            }

            $decoded = $this->service->verifyToken($token);
            if (!$decoded) {
                $this->respond(["valid" => false]);
                return;
            }
            $this->respond(["valid" => true, "user" => ['id' => $decoded->data->id, 'username' => $decoded->data->username, 'email' => $decoded->data->email, 'isAdmin' => $decoded->data->is_admin]]);
        } catch (Exception $e) {
            $this->respondWithError(400, $e->getMessage());
        }
    }
}