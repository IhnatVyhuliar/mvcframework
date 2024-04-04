<?php namespace Controllers;
    class FontsController {
        public static function Trigger(string $url): void {
            switch (pathinfo($url)["extension"]) {
                case "svg":
                    header("Content-Type: image/svg+xml");
                    
                    break;
                
                case "ttf":
                    header("Content-Type: application/x-font-ttf");
                    
                    break;
                    
                case "oft":
                    header("Content-Type: image/x-font-opentype");
                    
                    break;

                case "woff":
                    header("Content-Type: application/font-woff");
                    
                    break;

                case "woff2":
                    header("Content-Type: application/font-woff2");
                    
                    break;
            }

            echo file_get_contents("./src/Views/fonts/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
