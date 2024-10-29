<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\User;

class UserController extends Controller
{
    private $userModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->userModel = new User();
        $this->helper = $helper;
    }

    public function index()
    {
        $this->view("admin/dashboard.php", [
            "user" => $this->helper->getSessionUser(),
            "title" => "Dashboard"
        ]);
    }

    // Method to handle displaying all users
    public function listUsers()
    {
        $this->view("admin/users/list.php", [
            "user" => $_SESSION['user'],
            "users" => $this->userModel->readAll(),
            "title" => "Users"
        ]);
    }

    // Method to handle creating a user
    public function create()
    {
        ['username' => $username, 'email' => $email, 'new-password' => $password] = $_POST;

        $new_user = [];
        $status = 200;
        $message = "";
        if ($this->userModel->findByUsername($username)) {
            $status = 409;
            $message = "There is already a user with that username.";
        } else if ($this->userModel->findByEmail($email)) {
            $status = 409;
            $message = "There is already a user with that email.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_user, $status, $message);
        }

        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password_hash = $password;

        if ($this->userModel->create()) {
            $message = "User created successfully.";
            $new_user = $this->userModel->findByEmail($email);
            unset($new_user['password_hash']);
        } else {
            $status = 409;
            $message = "Error creating user.";
        }

        $this->helper->respondToClient($new_user, $status, $message);
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
