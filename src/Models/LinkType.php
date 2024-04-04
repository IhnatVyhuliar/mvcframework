<?php namespace Models;
    enum LinkType {
        case Invalid;
        case Verify;
        case ChangePassword;
        case ResetPassword;

        public static function LinkTypeFromString(string $type): LinkType {
            return match($type) {
                "-1" => LinkType::Invalid,
                "0" => LinkType::Verify,
                "1" => LinkType::ChangePassword,
                "2" => LinkType::ResetPassword
            };
        }

        public static function StringFromLinkType(LinkType $type): string {
            return match($type) {
                LinkType::Invalid => "-1",
                LinkType::Verify => "0",
                LinkType::ChangePassword => "1",
                LinkType::ResetPassword => "2"
            };
        }
    }
?>
