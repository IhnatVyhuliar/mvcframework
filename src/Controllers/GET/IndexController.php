<?php namespace Controllers\GET;
    use Controllers\PageController;

    class IndexController {
        public static function Trigger(string $url): void {
            header("Cache-Control: ncache, store, must-revalidate");
            header("Pragma: cache");
            header("Expires: 900000");
            header("Content-Type: text/html");
            echo PageController::GetPage('index.html');
        }
    }
?>
