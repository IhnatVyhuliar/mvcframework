<?php namespace Services;
    use Services\QueryService;
    use Services\UUIDService;
    use Models\Link;
    use Models\LinkType;

    class LinkService {
        private static ?LinkService $instance = null;

        public static function GetInstance(): LinkService {
            if (is_null(self::$instance)) {
                self::$instance = new LinkService();
            }

            return self::$instance;
        }

        public function GetLinkData(array $columns, array $values, bool $specific = true): ?array {
            return QueryService::GetInstance()->GetData("links", $columns, $values, $specific);
        }

        public function GetLinkDataWithSpecificSQL(string $sql, array $values): ?array {
            return QueryService::GetInstance()->GetDataWithSpecificSQL($sql, $values);
        }

        public function InsertLinkData(array $values): bool {
            return QueryService::GetInstance()->InsertData("links", $values);
        }
        
        public function UpdateLinkData(array $columns, array $values, bool $specific = true): bool {
            return QueryService::GetInstance()->UpdateData("links", $columns, $values, $specific);
        }

        public function DeleteLinkData( array $values, bool $specific = true): bool {
            return QueryService::GetInstance()->DeleteData("links", $values, $specific);
        }

        public function CheckIfLinkExists(array $values, bool $specific = true): ?bool {
            return QueryService::GetInstance()->CheckIfExists("links", $values, $specific);
        }

        public function CreateLink(string $user_uuid, string $expired_at, LinkType $type): ?array {
            if (!UUIDService::CheckIfUUIDExistsInTable($user_uuid, "users")) {
                return null;
            }

            $uuid = UUIDService::GetUniqueUUID("links");

            if (!$this->InsertLinkData(
                array(
                    "uuid" => $uuid,
                    "user_uuid" => $user_uuid,
                    "expired_at" => $expired_at,
                    "type" => LinkType::StringFromLinkType($type)
                )
            )) {
                return null;
            }

            return $this->GetLinkByUUID($uuid);
        }

        public function GetLinkByUUID(string $uuid): ?array {
            if (!UUIDService::CheckIfUUIDExistsInTable($uuid, "links")) {
                return null;
            }
            
            $data = $this->GetLinkData(
                array(
                    "uuid",
                    "user_uuid",
                    "expired_at",
                    "type"
                ), array(
                    "uuid" => $uuid
                )
            )[0];

            return new Link(
                strval($data["uuid"]),
                strval($data["user_uuid"]),
                strval($data["expired_at"]),
                strval($data["type"])
            );
        }

        public function DeleteLinkByUUID(string $uuid): bool {
            if (!UUIDService::CheckIfUUIDExistsInTable($uuid, "links")) {
                return false;
            }

            return $this->DeleteLinkData(array("uuid" => $uuid));
        }
    }
?>
