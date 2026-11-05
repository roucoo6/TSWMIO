<?php
require_once(__DIR__."/I18n.php");

function t(string $key): string {
    return i18n($key);
}
