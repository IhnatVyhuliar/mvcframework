<?php namespace Controllers\GET;
    use Controllers\PageController;
    use Middleware\GET\DashboardMiddleware;

    class DashboardController {
        public static function Trigger(string $url): void {
            DashboardMiddleware::CheckRedirect();

            header("Content-Type: text/html");
            echo PageController::GetPage("dashboard.html");
        }
    }
?>
