<?php namespace Middleware\POST;
    use Services\QueryService;
    use Services\DataHandleService;
    use Controllers\GET\PageController;
    use Services\UserService;
    use Services\LoginService;
    use Services\MailService;
    use Services\LinkService;
    use Models\LinkType;
    use Services\SessionService;
    use SessionHandler;

    class RegisterMiddleware {
        public static function RegisterUser(string $username, string $email, string $password): bool {
            QueryService::GetInstance()->EstablishConnection($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

            $user = UserService::GetInstance()->CreateUser("", "", $username, $email, "0000-00-00", $password);
            SessionService::AddVariable("user", $user);
            
            return MailService::GetInstance()->SendMail(
                $user->GetEmail(),
                $user->GetName(),
                "[FireSpark] Verify your email!",
                PageController::GetModifiedPage(
                    "email_verify.html",
                    array(
                        "{link}" => DataHandleService::GetLink(),
                        "{uuid}" => LinkService::GetInstance()->CreateLink(
                            $user->GetUUID(),
                            date("Y-m-d", strtotime($user->GetCreatedAccount(). " + 1 days")),
                            LinkType::Verify
                        )["uuid"],
                    )
                )
            );
        }
    }
?>
