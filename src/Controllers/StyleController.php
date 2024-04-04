<?php namespace Controllers;
    class StyleController {
        public static function Trigger(string $url): void {
            header("Content-Type: text/css");
            echo file_get_contents("./src/Views/css/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
