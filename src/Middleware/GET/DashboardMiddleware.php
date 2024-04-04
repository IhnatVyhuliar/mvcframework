<?php namespace Middleware\GET;
    use Services\SessionService;
    use Models\Status;
    
    class DashboardMiddleware {
        public static function CheckRedirect(): void {
        //     if (!SessionService::CheckIfVariableExists("user")) {
        //         header('Location: /login');
        //     } else if (SessionService::GetVariable("user")->GetStatus() === Status::Blocked) {
        //         header('Location: /');
        //     }
        }
    }
?>
