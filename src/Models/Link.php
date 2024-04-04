<?php namespace Models;
    use Models\LinkType;

    class Link {
        private ?string $uuid = null;
        private ?string $user_uuid = null;
        private ?string $expired_at = null;
        private ?LinkType $type = null;

        public function __construct(string $uuid, string $user_uuid, string $expired_at, string $type) {
            $this->uuid = $uuid;
            $this->user_uuid = $user_uuid;
            $this->expired_at = $expired_at;
            $this->type = LinkType::LinkTypeFromString($type);
        }

        public function GetData(): array {
            return array(
                "uuid" => $this->uuid,
                "user_uuid" => $this->user_uuid,
                "expired_at" => $this->expired_at,
                "type" => LinkType::StringFromLinkType($this->type)
            );
        }
    }
?>
