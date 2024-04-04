<?php namespace Controllers\POST;
    use Middleware\POST\LoginMiddleware;
    use Resources\JSONResource;
    
    class LoginController {
        public static function Trigger(): void {
            if (!LoginMiddleware::LoginUser($_POST["email"], $_POST["password"])) {
                header("Location: /login");
                
                return;
            }

            

            header("Location: /dashboard");
        }
    }
?>
