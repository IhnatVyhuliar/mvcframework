<?php namespace Services;
    class CookieService {
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
