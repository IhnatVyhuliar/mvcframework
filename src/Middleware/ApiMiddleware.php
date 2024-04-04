<?php namespace Middleware;
    use Interfaces\MiddlewareInterface;
    use Models\User;
    
    class APIMiddleware implements MiddlewareInterface {
        public function CheckRedirect(User $user = null, int $status_page): bool {
            /* 
                $user->api_access could be only 0 or 1 
                api_access should have only users with extra permissions
                by default every user doesm't have permissions to use api
            */

            if ($user->api_access) {
                return true;
            } else {
                /*
                    header('HTTP/1.0 403 Forbidden');
                    echo 'You are forbidden!';
                */

                return false;
            }
        }
    }
?>
