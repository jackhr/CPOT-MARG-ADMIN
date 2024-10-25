<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $user = $_SESSION['user'];
        $this->view("admin/dashboard.php", compact("user"));
    }

    // Method to handle displaying all users
    public function listUsers()
    {
        $user = $_SESSION['user'];
        $users = $this->userModel->readAll();
        $this->view("admin/users/list.php", compact("user", "users"));
    }

    // Method to handle creating a user
    public function createUser($username, $email, $password)
    {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password_hash = $password;

        if ($this->userModel->create()) {
            echo "User created successfully.";
        } else {
            echo "Error creating user.";
        }
    }

    // Method to handle viewing a specific user by ID
    public function viewUser($id)
    {
        $user = $this->userModel->findById($id);
        if ($user) {
            print_r($user);
        } else {
            echo "User not found.";
        }
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user'] = $user;
            $location = "/dashboard";
        } else {
            $location = "/?error=invalid_credentials";
        }
        header("Location: $location");
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /");
    }
}
