<?php namespace Controllers;
    class PageController {
        public static function GetPage(string $filename): string {
            return file_get_contents('./src/Views/'. $filename);
        }
    }
?>
