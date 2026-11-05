<?php
class ViewManager {
    private static ?ViewManager $instance = null;
    private array $variables = array();
    private ?string $fragment = null;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance(): ViewManager {
        if (self::$instance === null) {
            self::$instance = new ViewManager();
        }
        return self::$instance;
    }

    public function setVariable(string $name, $value): void {
        $this->variables[$name] = $value;
    }

    public function getVariable(string $name) {
        return $this->variables[$name] ?? null;
    }

    public function setFlash(string $flash): void {
        $_SESSION["__flash__"] = $flash;
    }

    public function popFlash(): ?string {
        $flash = $_SESSION["__flash__"] ?? null;
        unset($_SESSION["__flash__"]);
        return $flash;
    }

    public function render(string $controller, string $view): void {
        ob_start();
        $file = __DIR__."/../view/".$controller."/".$view.".php";
        if (file_exists($file)) {
            require($file);
        }
        $this->fragment = ob_get_clean();

        require(__DIR__."/../view/layouts/default.php");
    }

    public function getFragment(string $name): string {
        if ($name === "content") {
            return $this->fragment ?? "";
        }
        return "";
    }

    public function redirect(string $controller, string $action, string $params = ""): void {
        $url = "index.php?controller=".$controller."&action=".$action;
        if (!empty($params)) {
            $url .= "&".$params;
        }
        header("Location: ".$url);
        exit();
    }
}
