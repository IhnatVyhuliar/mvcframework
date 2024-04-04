<?php namespace Controllers;
    class AudioController {
        public static function Trigger(string $url): void {
            switch (pathinfo($url)["extension"]) {
                case "mp4":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp4a":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp4p":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp4b":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp4r":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp4v":
                    header("Content-Type: audio/mp4");
                    
                    break;

                case "mp3":
                    header("Content-Type: audio/mpeg");
                    
                    break;
                    
                case "wav":
                    header("Content-Type: audio/x-wav");
                    
                    break;

                case "wave":
                    header("Content-Type: audio/x-wav");
                    
                    break;
            }
            
            echo file_get_contents("./src/Views/audio/". pathinfo($url)["filename"]. ".". pathinfo($url)["extension"]);
        }
    }
?>
