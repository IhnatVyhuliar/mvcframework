<?php namespace Routes;
    use Routes\Website\Router;

    class Routes {
        public static function CreateRoutes(Router $router) {
            $router->GET("/css/*.css", "Controllers\\StyleController");
            $router->GET("/js/*.js", "Controllers\\ScriptController");
            $router->GET("/img/*.*", "Controllers\\ImageController");
            $router->GET("/audio/*.*", "Controllers\\AudioController");
            $router->GET("/video/*.*", "Controllers\\VideoController");
            $router->GET("/fonts/*.*", "Controllers\\FontsController");
            
            $router->POST("/login", "Controllers\\POST\\LoginController");
            $router->POST("/register", "Controllers\\POST\\RegisterController");

            $router->GET("/", "Controllers\\GET\\IndexController");

            $router->GET("/config", "Controllers\\GET\\ConfigController");
            $router->GET("/login", "Controllers\\GET\\LoginController");
            $router->GET("/dashboard", "Controllers\\GET\\DashboardController");
            $router->GET("/link", "Controllers\\GET\\LinkController");
        }
    }
?>
