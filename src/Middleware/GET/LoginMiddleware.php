<?php namespace Middleware\GET;
    use Services\SessionService;
    use Models\Status;

    class LoginMiddleware {
        public static function CheckRedirect(): void {
            // if (SessionService::CheckIfVariableExists("user")) {
            //     header('Location: /dashboard');
            // } else if (SessionService::CheckIfVariableExists("user") && SessionService::GetVariable("user")->GetStatus() === Status::Blocked) {
            //     header('Location: /');
            // }
        }
    }
?>
