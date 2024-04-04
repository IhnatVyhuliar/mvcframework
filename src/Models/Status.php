<?php namespace Models;
    enum Status {
        case Blocked;
        case Default;
        case UserDocs;
        case UserEngineDev;
        case Admin;

        public static function StatusTypeFromString(string $type): Status {
            return match($type) {
                '-1' => Status::Blocked,
                '0' => Status::Default,
                '1' => Status::UserDocs,
                '2' => Status::UserEngineDev,
                '3' => Status::Admin
            };
        }

        public static function StringFromStatusType(Status $type): string {
            return match($type) {
                Status::Blocked => "-1",
                Status::Default => '0',
                Status::UserDocs => '1',
                Status::UserEngineDev => '2',
                Status::Admin => '3'
            };
        }
    }
?>
