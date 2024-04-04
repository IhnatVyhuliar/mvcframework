<?php namespace Models;
	enum DebugLevel {
		case None;
		case Notice;
		case Warning;
		case Error;

		public static function DebugLevelFromPHPErrorLevel(int $type): DebugLevel {
            return match($type) {
                E_USER_NOTICE => DebugLevel::Notice,
                E_USER_WARNING => DebugLevel::Warning,
                E_USER_ERROR => DebugLevel::Error
            };
        }
		
		public static function PHPErrorLevelFromDebugLevel(DebugLevel $type): int {
            return match($type) {
                DebugLevel::Notice => E_USER_NOTICE,
                DebugLevel::Warning => E_USER_WARNING,
                DebugLevel::Error => E_USER_ERROR
            };
        }

		public static function StringFromDebugLevelType(DebugLevel $type): string {
            return match($type) {
				DebugLevel::None => "Undefined",
                DebugLevel::Notice => "Notice",
                DebugLevel::Warning => "Warning",
                DebugLevel::Error => "Error"
            };
        }

        public static function DebugLevelTypeFromString(string $type): DebugLevel {
            return match($type) {
                "Undefined" => DebugLevel::None,
				"Notice" => DebugLevel::Notice,
                "Warning" => DebugLevel::Warning,
                "Error" => DebugLevel::Error
            };
        }
	};
?>
