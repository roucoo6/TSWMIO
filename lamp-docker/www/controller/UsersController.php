<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

class UsersController extends BaseController {
    private UserMapper $userMapper;

    public function __construct() {
        parent::__construct();
        $this->userMapper = new UserMapper();
    }

    public function login() {
        if (isset($_POST["username"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            if ($this->userMapper->isValidUser($username, $password)) {
                $_SESSION["currentuser"] = $username;
                $this->view->setFlash(sprintf(i18n("Welcome back, %s!"), $username));
                $this->view->redirect("events", "index");
            } else {
                $errors = array();
                $errors["general"] = i18n("Username or password is incorrect");
                $this->view->setVariable("errors", $errors);
            }
        }
        $this->view->render("users", "login");
    }

    public function register() {
        $user = new User();

        if (isset($_POST["username"])) {
            $user->setUsername($_POST["username"]);
            $user->setPassword($_POST["password"]);
            $user->setEmail($_POST["email"] ?? "");

            try {
                $user->checkIsValidForRegister();

                if (!$this->userMapper->usernameExists($user->getUsername())) {
                    $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
                    $this->userMapper->save($user);

                    $this->view->setFlash(i18n("User successfully registered. Please log in."));
                    $this->view->redirect("users", "login");
                } else {
                    $errors = array();
                    $errors["username"] = i18n("Username already exists");
                    $this->view->setVariable("errors", $errors);
                }
            } catch (ValidationException $ex) {
                $this->view->setVariable("errors", $ex->getErrors());
            }
        }

        $this->view->setVariable("user", $user);
        $this->view->render("users", "register");
    }

    public function logout() {
        session_destroy();
        $this->view->redirect("users", "login");
    }
}
