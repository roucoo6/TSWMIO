<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../model/UserMapper.php");

class BaseController {
    protected ViewManager $view;
    protected ?User $currentUser = null;

    public function __construct() {
        $this->view = ViewManager::getInstance();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["currentuser"])) {
            $userMapper = new UserMapper();
            $this->currentUser = $userMapper->findByUsername($_SESSION["currentuser"]);
        }
        $this->view->setVariable("currentuser", $_SESSION["currentuser"] ?? null);
    }
}
