<?php namespace Controllers\GET;
    use Services\LinkService;
    use Services\UUIDService;
    use Services\UserService;

    class LinkController {
        public static function GetPage(): void {
            if (!isset($_GET["uuid"])) {
                //header("Location: /login");

                return;
            }
            
            if (!UUIDService::CheckIfUUIDExistsInTable($_GET["uuid"], "links")) {
                //header("Location: /login");

                return;
            }

            $link_service = new LinkService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
            $link_data = $link_service->GetLinkByUUID($_GET["uuid"]);

            // TODO: Check if link expired!

            $date_now = date("Y-m-d", time());
            $date_pdo = $link_data["expired_at"];

            if ($date_pdo < $date_now) {
                //header("Location: /login");

                return;
            }

            switch ($link_data["type"]) {
                case "0":
                    $user_service = new UserService($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
                    $res = $user_service->UpdateUserData(array("uuid" => $link_data['user_uuid'], "email_verified" => true));
                    
                    if ($res) {
                        $link_service->DeleteLinkByUUID($link_data["uuid"]);
                    }
                    
                    break;
                    
                case "1":
            }

            //header("Location: /login");
        }
    }
?>
