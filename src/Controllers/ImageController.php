<?php namespace Controllers;
    class ImageController {
        public static function Trigger(string $url): void {
            switch (pathinfo($url)["extension"]) {
                case "svg":
                    header("Content-Type: image/svg+xml");
                    
                    break;
                
                case "jpg":
                    header("Content-Type: image/jpg");
                    
                    break;
                    
                case "jpeg":
                    header("Content-Type: image/jpeg");
                    
                    break;
                    
                case "png":
                    header("Content-Type: image/png");
                    
                    break;
                    
                case "tiff":
                    header("Content-Type: image/tiff");
                    
                    break;
                    
                case "gif":
                    header("Content-Type: image/gif");
                    
                    break;

                case "ico":
                    header("Content-Type: image/x-icon");
                    
                    break;

                case "webp":
                    header("Content-Type: image/webp");

                    break;

                case "avif":
                    header("Content-Type: image/avif");

                    break;
            }
            
            echo file_get_contents("./src/Views/img/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
