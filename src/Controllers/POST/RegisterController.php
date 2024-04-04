<?php namespace Controllers\POST;
    use Middleware\POST\RegisterMiddleware;

    class RegisterController {
        public static function Trigger(): void {
            if (!RegisterMiddleware::RegisterUser($_POST["username"], $_POST["email"], $_POST["password"])) {
                header("Location: /login");

                return;
            }
            
            header("Location: /dashboard");
        }
    }
?>
