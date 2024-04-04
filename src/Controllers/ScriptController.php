<?php namespace Controllers;
    class ScriptController {
        public static function Trigger(string $url): void {
            header("Content-Type: application/javascript");
            echo file_get_contents("./src/Views/js/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
