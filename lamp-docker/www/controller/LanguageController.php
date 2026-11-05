<?php
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../core/ViewManager.php");

class LanguageController {
    public function change(): void {
        if (isset($_GET["lang"])) {
            I18n::getInstance()->setLanguage($_GET["lang"]);
        }
        $referer = $_SERVER["HTTP_REFERER"] ?? "index.php";
        header("Location: ".$referer);
        exit();
    }
}
