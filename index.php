<?php
    use Dotenv\Dotenv;
    use Services\SessionService;
    use Routes\Routes;
    use Routes\Website\Router;
    use Models\MethodType;
    use Services\UUIDService;

    
    require_once(__DIR__. "/vendor/autoload.php");
    
    function main(array $args = array(), array $kwargs = array()): int {
        SessionService::StartSession();
        
        $dotenv = Dotenv::CreateImmutable(__DIR__);
        $dotenv->Load();

        $router = new Router();

        Routes::CreateRoutes($router);

        $router->Route($kwargs["url"], MethodType::MethodTypeFromString($kwargs["method"]));

        return 0;
    }
    
    main(array(), array("url" => $_POST["_METHOD"] ?? parse_url($_SERVER["REQUEST_URI"])["path"], "method" => $_SERVER["REQUEST_METHOD"]));
?>
