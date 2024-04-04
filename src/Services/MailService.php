<?php namespace Services;
    class MailService {
        private static ?MailService $instance = null;
        private ?array $mail = array(
            "host" => "smtp.gmail.com",
            "port" => 587,
            "from" => "os.pietrzko@gmail.com"
        );

        public static function GetInstance(): MailService {
            if (is_null(self::$instance)) {
                self::$instance = new MailService();
            }

            return self::$instance;
        }

        public function ConfigureMailService(array $data = array()): void {  
            $this->mail = array(
                "host" => $data["host"] ?? "smtp.gmail.com",
                "port" => $data["port"] ?? 587,
                "from" => $data["from"] ?? "os.pietrzko@gmail.com"
            );
        }

        public function SendMail(string $mail, string $name, string $subject, string $message): bool {
            return $this->SMTPSend($mail, $name, $subject, $message);
        }

        private function SMTPSend(string $mail, string $name, string $subject, string $message): bool {
            $headers =  "From: ". $this->mail["from"]. "\r\n".
                        "To: ". $name. " ". $mail. "\r\n".
                        "MIME-Version: 1.0". "\r\n".
                        "Content-type: text/html;charset=UTF-8";
            
            return mail($mail, $subject, $message, $headers);
        }
    }
?>
