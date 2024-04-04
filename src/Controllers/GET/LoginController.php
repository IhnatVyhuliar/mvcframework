<?php namespace Controllers\GET;
    use Controllers\PageController;
    use Middleware\GET\LoginMiddleware;

    class LoginController {
        public static function Trigger(string $url): void {
            // if(!LoginMiddleware::CheckRedirect()) {
            //     header("Location: /dashboard");
                
            //     return;
            // }
            
            header("Content-Type: text/html");
            echo PageController::GetPage("login.html");
        }
    }
?>