<?php namespace Log;
    use Models\DebugLevel;
    
    class Logger {
        private static ?Logger $instance = null;

        public function __construct() {
            error_reporting(E_ALL);
            set_error_handler(array($this, 'ErrorHandler'));
        }

        public function ErrorHandler(int $errno, string $errstr, string $errfile, int $errline): void {
            switch ($errno) {
                case E_USER_NOTICE:
                    $this->Notice(array("message" => $errstr, "file" => $errfile, "line" => $errline));

                    break;

                case E_USER_WARNING:
                    $this->Warning(array("message" => $errstr, "file" => $errfile, "line" => $errline));
                    
                    break;

                case E_USER_ERROR:
                    $this->Error(array("message" => $errstr, "file" => $errfile, "line" => $errline));
            
                    break;
    
                default:
                    $this->Log(DebugLevel::None, array("message" => $errstr, "file" => $errfile, "line" => $errline));

                    break;
            }

            die();
        }

        public static function GetData(object $exception): array {
            return array("message" => $exception->GetMessage(), "file" => $exception->GetFile(), "line" => $exception->GetLine());
        }

        public static function GetInstance(): Logger {
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function Notice(array $data): void {
            $this->Log(DebugLevel::Notice, $data);
        }

        public function Warning(array $data) {
            $this->Log(DebugLevel::Warning, $data);
        }

        public function Error(array $data) {
            $this->Log(DebugLevel::Error, $data);
        }
        
        private function Log(DebugLevel $level, array $data): void {
            $date_time = date("Y-m-d H:i:s", time());
            $error_type = DebugLevel::StringFromDebugLevelType($level);
            $str = "[". $date_time. "] [". $error_type. "]"; 

            if (isset($data["file"]) && isset($data["line"])){
                $str .= " [". $data["file"]. ":". $data["line"]. "]";
            }

            $str .= " [". $data["message"]. "]\n";
            $file = fopen("data.log", "a");

            fwrite($file, $str);
            fclose($file);

            if ($_ENV["DEBUG_MODE"] === "TRUE") {
                $color = "#fff";

                switch ($level) {
                    case DebugLevel::Warning:
                        $color = "#eedc82";
                        
                        break;

                    case DebugLevel::Error:
                        $color = "#c1220c";

                        break;
                }   
                
                echo "<body style=\"background-color: #333\">";
                echo "<p style=\"color: ". $color. "; font-size: 30px; font-weight: 900; font-family: 'Helvetica san serif';\">". $str ."<p><br />";
                echo "</body>";
            }
        }
    }
?>
