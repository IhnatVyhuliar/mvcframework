<?php namespace Middleware;
    use Interfaces\MiddlewareInterface;
    use Models\User;
    
    class WebsiteMiddleware implements MiddlewareInterface {
        public function CheckRedirect(User $user = null, int $status_page): bool {
            /*
                $status_page 0 means that this page is available for public 
                otherwise it is available for users with extra permissions
            */

            if ($user->status > 0 || $status_page == 0) {
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
