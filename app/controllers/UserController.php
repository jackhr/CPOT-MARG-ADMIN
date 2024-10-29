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
        } else {
            $status = 409;
            $message = "Error creating user.";
        }

        $this->helper->respondToClient($new_user, $status, $message);
    }

    public function update($user_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        ['username' => $username, 'email' => $email, 'user_id' => $user_id] = $data;

        $user = $this->userModel->findById($user_id);
        $user_with_same_username = $this->userModel->findByUsername($username);
        $user_with_same_email = $this->userModel->findByEmail($email);
        $status = 200;
        $message = "";

        if (!$user) {
            $status = 409;
            $message = "There is no user with this id.";
        } else if (
            ($user_with_same_username['username'] === $username) &&
            ($user_with_same_username['user_id'] !== $user['user_id'])
        ) {
            $status = 409;
            $message = "There is already a user with that username.";
        } else if (
            ($user_with_same_email['email'] === $email) &&
            ($user_with_same_email['user_id'] !== $user['user_id'])
        ) {
            $status = 409;
            $message = "There is already a user with that email.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($user, $status, $message);
        }

        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->user_id = $user_id;

        if ($this->userModel->update()) {
            $message = "User updated successfully.";
            $updated_user = $this->userModel->findByEmail($email);
        } else {
            $status = 409;
            $message = "Error updating user.";
        }

        $this->helper->respondToClient($updated_user, $status, $message);
    }

    public function delete($user_id)
    {
        $logged_in_user = $_SESSION['user'];

        $user_to_delete = $this->userModel->findById($user_id);
        $status = 200;
        $message = "";

        if ($logged_in_user['user_id'] === (int)$user_id) {
            $status = 409;
            $message = "You cannot delete your own user.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        $this->userModel->user_id = $user_id;

        if ($this->userModel->delete()) {
            $message = "User deleted successfully.";
            $user_to_delete = $this->userModel->findById($user_id);
        } else {
            $status = 409;
            $message = "Error updating user.";
        }

        $this->helper->respondToClient($user_to_delete, $status, $message);
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
        $user = $this->userModel->findByEmail($email, true);
        // $this->helper->dd($user, false);
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
