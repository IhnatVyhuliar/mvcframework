<?php namespace Services;
    class SessionService {
        public static function StartSession(array $data = array()): bool {
            return session_start([
                "use_cookies" => $data["use_cookies"] ?? true,
                "use_only_cookies" => $data["use_only_cookies"] ?? true,
                "cookie_path" => $data["cookie_path"] ?? "/",
                "cookie_lifetime" => $data["cookie_lifetime"] ?? 900,
                "cookie_secure" => $data["cookie_secure"] ?? true,
                "cookie_httponly" => $data["cookie_httponly"] ?? true,
                "read_and_close" => $data["read_and_close"] ?? false
            ]);
        }

        public static function RestartSession(): bool {
            return session_reset();
        }
        
        public static function StopSession(): bool {
            if (!SessionService::GetSessionStatus()) {
                return false;
            }

            return session_destroy();
        }
        
        public static function CleanSession(): bool {
            if (!SessionService::GetSessionStatus()){
                return false;
            }

            return session_unset();
        }

        public static function GetSessionStatus(): bool {
            return session_start() === 2 ? true : false;
        }

        public static function GetData(): array|null {
            return $_SESSION ?? null;
        }

        public static function CheckIfVariableExists(string $name): bool {
            return isset($_SESSION[$name]);
        }

        public static function RemoveVariable(string $name): bool {
            if (!SessionService::CheckIfVariableExists($name)) {
                return false;
            }

            unset($_SESSION[$name]);

            return !SessionService::CheckIfVariableExists($name);
        }

        public static function AddVariable(string $name, mixed $variable): bool {
            if (SessionService::CheckIfVariableExists($name)) {
                return false;
            }

            $_SESSION[$name] = $variable;

            return SessionService::CheckIfVariableExists($name);
        }

        public static function GetVariable(string $name): mixed {
            if (!SessionService::CheckIfVariableExists($name)) {
                return null;
            }
            
            return $_SESSION[$name];
        }
            
        public static function SetVariable(string $name, mixed $variable): bool {
            $_SESSION[$name] = $variable;

            return SessionService::CheckIfVariableExists($name);
        }

        public static function ReplaceVariable(string $name, mixed $variable): bool {
            if (!SessionService::CheckIfVariableExists($name)) {
                return false;
            }
            
            SessionService::RemoveVariable($name);
            SessionService::AddVariable($name, $variable);

            return SessionService::CheckIfVariableExists($name);
        }
    }
?>
