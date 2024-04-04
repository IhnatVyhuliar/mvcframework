<?php namespace Services;
    use Services\UserService;
    use Services\DataHandleService;
    use Services\UUIDService;
    use Services\LinkService;
    use Services\MailService;

    class MailHandleService {
        public static function ResetPasswordLink(string $email): bool {
            if (UUIDService::CheckIfUUIDExistsInTable($uuid, "links")) {
                return false;
            }
            
            $link_service = new LinkService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
            $link_service->CreateLink();

            $user_service = new UserService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
            $user_uuid = $link_service->GetLinkUserUUIDProperty($uuid);
            
            if(!UUIDService::CheckIfUUIDExistsInTable($user_uuid, "users")) {
                return false;
            }

            $mail_service = new MailService();

            $mail_service->SendMail($user_service->GetUserEmailProperty(), $user_service->GetUserUsernameProperty(), "[FireSpark] Verify your email!", PageController::returnVerifyPage($verify_uuid, "emaiverify.html", "verify"));

            return true;
        }
        
        public static function VerifyUser(string $uuid): bool {
            if (UUIDService::CheckIfUUIDExistsInTable($uuid, "links")){
                return false;
            }

            $link_service = new LinkService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
            $user_service = new UserService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
            $user_uuid = $link_service->GetLinkUserUUIDProperty($uuid);
            
            if(!UUIDService::CheckIfUUIDExistsInTable($user_uuid, "users")) {
                return false;
            }

            return $user_service->SetUserEmailVerifiedProperty($user_uuid, true);
        }
    }
?>
