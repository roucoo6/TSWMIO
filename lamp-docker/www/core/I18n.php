<?php
class I18n {
    private static ?I18n $instance = null;
    private array $messages;
    private string $currentLanguage;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->currentLanguage = $_SESSION["currentlang"] ?? "es";
        $this->loadMessages($this->currentLanguage);
    }

    public static function getInstance(): I18n {
        if (self::$instance === null) {
            self::$instance = new I18n();
        }
        return self::$instance;
    }

    public function setLanguage(string $language): void {
        $this->currentLanguage = $language;
        $_SESSION["currentlang"] = $language;
        $this->loadMessages($language);
    }

    private function loadMessages(string $language): void {
        $file = __DIR__."/../view/messages/messages_".$language.".php";
        if (file_exists($file)) {
            require($file);
            $this->messages = $i18n_messages ?? array();
        } else {
            $this->messages = array();
        }
    }

    public function i18n(string $key): string {
        return $this->messages[$key] ?? $key;
    }
}

function i18n(string $key): string {
    return I18n::getInstance()->i18n($key);
}
