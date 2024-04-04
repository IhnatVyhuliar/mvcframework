<?php namespace Middleware\POST;
    use Services\QueryService;
    use Services\UserService;
    use Services\SessionService;

    class LoginMiddleware {
        public static function LoginUser(string $email, string $password): bool {
            QueryService::GetInstance()->EstablishConnection($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
            
            return SessionService::SetVariable("user", UserService::GetInstance()->GetUserByEmail($email, $password));
        }
    }
?>
