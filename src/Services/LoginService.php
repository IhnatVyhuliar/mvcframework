<?php namespace Services;
    use Models\User;
    use Services\SessionService;

    class LoginService {
        public static function Login(User $user): bool {
            return SessionService::SetVariable("user", $user);
        }

        public static function GetUser(): ?User {
            return SessionService::GetVariable("user");
        }

        public static function CheckIfUserLogin(): bool {
            return SessionService::CheckIfVariableExists("user");
        }
    }
?>
