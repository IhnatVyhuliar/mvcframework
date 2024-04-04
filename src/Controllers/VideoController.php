<?php namespace Controllers;
    class VideoController {
        public static function Trigger(string $url): void {
            switch (pathinfo($url)["extension"]) {
                case "mp4":
                    header("Content-Type: video/mp4");
                    
                    break;

                case "mp4a":
                    header("Content-Type: video/mp4");
                    
                    break;

                case "mp4p":
                    header("Content-Type: video/mp4");
                    
                    break;

                case "mp4b":
                    header("Content-Type: video/mp4");
                    
                    break;

                case "mp4r":
                    header("Content-Type: video/mp4");
                    
                    break;

                case "mp4v":
                    header("Content-Type: video/mp4");
                    
                    break;
                    
                case "mov":
                    header("Content-Type: video/quicktime");
                    
                    break;

                case "movie":
                    header("Content-Type: video/quicktime");
                    
                    break;

                case "qt":
                    header("Content-Type: video/quicktime");
                    
                    break;
            }
            
            echo file_get_contents("./src/Views/video/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
