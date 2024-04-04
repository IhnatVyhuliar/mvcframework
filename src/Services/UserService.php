<?php namespace Services;
    use Models\Status;
    use Services\DataHandleService;
    use Services\UUIDService;
    use Models\User;
    use Services\QueryService;
    
    class UserService {
        private static ?UserService $instance = null;

        public static function GetInstance(): UserService {
            if (is_null(self::$instance)) {
                self::$instance = new UserService();
            }

            return self::$instance;
        }
        
        public static function GetUserData(array $columns, array $values, bool $specific = true): ?array {
            return QueryService::GetData("users", $columns, $values, $specific);
        }

        public static function GetUserDataWithSpecificSQL(string $sql, array $values): ?array {
            return QueryService::GetDataWithSpecificSQL($sql, $values);
        }

        public static function InsertUserData(array $values): bool {
            return QueryService::InsertData("users", $values);
        }
        
        public static function UpdateUserData(array $columns, array $values, bool $specific = true): bool {
            return QueryService::UpdateData("users", $columns, $values, $specific);
        }

        public static function DeleteUserData(array $values, bool $specific = true): bool {
            return QueryService::DeleteData("users", $values, $specific);
        }

        public static function CheckIfUserExists(array $values, bool $specific = true): bool {
            return QueryService::CheckIfExists("users", $values, $specific);
        }

        public static function GetUserByUUID(string $uuid): ?User {
            return UserService::GetInstance()->GetUserByUUIDImplementation($uuid);
        }

        public static function GetUserByUsernameAndEmail(string $username, string $email, string $password): ?User {
            return UserService::GetInstance()->GetUserByUsernameAndEmailImplementation($username, $email, $password);
        }

        public static function GetUserByUsername(string $username, string $password): ?User {
            return UserService::GetInstance()->GetUserByUsernameImplementation($username, $password);
        }

        public static function GetUserByEmail(string $email, string $password): ?User {
            return UserService::GetInstance()->GetUserByEmailImplementation($email, $password);
        }

        public static function CreateUser(string $name, string $surname, string $username, string $email, string $date_of_birth, string $password): ?User {
            return UserService::GetInstance()->CreateUserImplementation($name, $surname, $username, $email, $date_of_birth, $password);
        }

        private function GetUserByUUIDImplementation(string $uuid): ?User {
            if (!$this->CheckIfUserExists(array("uuid" => $uuid))) {
                return null;
            }

            $data = $this->GetUserData(array(
                "uuid",
                "name",
                "surname",
                "username", 
                "email",
                "email_verified",
                "date_birth",
                "status",
                "api_access",
                "password",
                "created_account"
            ), array(
                "uuid" => $uuid
            ))[0];

            return new User(
                strval($data["uuid"]), 
                strval($data["name"]),
                strval($data["surname"]), 
                strval($data["username"]),
                strval($data["email"]),
                boolval($data["email_verified"]),
                strval($data["date_birth"]), 
                Status::StatusTypeFromString(strval($data["status"])), 
                boolval($data["api_access"]), 
                strval($data["password"]),
                strval($data["created_account"])
            );
        }

        private function GetUserByUsernameAndEmailImplementation(string $username, string $email, string $password): ?User {
            if (!$this->CheckIfUserExists(array("username" => DataHandleService::SanitizeInput($username), "email" => DataHandleService::SanitizeInput($email)))) {
                return null;
            }

            $data = $this->GetUserData(array(
                "uuid",
                "name",
                "surname",
                "username", 
                "email",
                "email_verified",
                "date_birth",
                "status",
                "api_access",
                "password",
                "created_account"
            ), array(
                "username" => DataHandleService::SanitizeInput($username),
                "email" => DataHandleService::SanitizeInput($email)
            ))[0];

            if (!DataHandleService::CheckPassword($password, $data["password"])) {
                return null;
            }

            return new User(
                strval($data["uuid"]), 
                strval($data["name"]),
                strval($data["surname"]), 
                strval($data["username"]),
                strval($data["email"]),
                boolval($data["email_verified"]),
                strval($data["date_birth"]), 
                Status::StatusTypeFromString(strval($data["status"])), 
                boolval($data["api_access"]), 
                strval($data["password"]),
                strval($data["created_account"])
            );
        }

        private function GetUserByUsernameImplementation(string $username, string $password): ?User {
            if (!$this->CheckIfUserExists(array("username" => DataHandleService::SanitizeInput($username)))) {
                return null;
            }
            
            $data = $this->GetUserData(array(
                "uuid",
                "name",
                "surname",
                "username", 
                "email",
                "email_verified",
                "date_birth",
                "status",
                "api_access",
                "password",
                "created_account"
            ), array(
                "username" => DataHandleService::SanitizeInput($username)
            ))[0];

            if (!DataHandleService::CheckPassword($password, $data['password'])) {
                return null;
            }
            
            return new User(
                strval($data["uuid"]), 
                strval($data["name"]),
                strval($data["surname"]), 
                strval($data["username"]),
                strval($data["email"]),
                boolval($data["email_verified"]),
                strval($data["date_birth"]), 
                Status::StatusTypeFromString(strval($data["status"])), 
                boolval($data["api_access"]), 
                null,
                strval($data["created_account"])
            );
        }

        private function GetUserByEmailImplementation(string $email, string $password): ?User {
            if (!$this->CheckIfUserExists(array("email" => DataHandleService::SanitizeInput($email)))) {
                return null;
            }
            
            $data = $this->GetUserData(array(
                "uuid",
                "name",
                "surname",
                "username", 
                "email",
                "email_verified",
                "date_birth",
                "status",
                "api_access",
                "password",
                "created_account"
            ), array(
                "email" => DataHandleService::SanitizeInput($email)
            ))[0];

            if (!DataHandleService::CheckPassword($password, $data['password'])) {
                return null;
            }
            
            return new User(
                strval($data["uuid"]), 
                strval($data["name"]),
                strval($data["surname"]), 
                strval($data["username"]),
                strval($data["email"]),
                boolval($data["email_verified"]),
                strval($data["date_birth"]), 
                Status::StatusTypeFromString(strval($data["status"])), 
                boolval($data["api_access"]), 
                null,
                strval($data["created_account"])
            );
        }

        private function CreateUserImplementation(string $name, string $surname, string $username, string $email, string $date_of_birth, string $password): ?User {
            if ($this->CheckIfUserExists(array("username" => DataHandleService::SanitizeInput($username), "email" => DataHandleService::SanitizeInput($email)))) {
                return null;
            }
            
            $uuid = UUIDService::GetUniqueUUID("users");

            if (!$this->InsertUserData(array(
                "uuid" => $uuid,
                "name" => $name,
                "surname" => $surname,
                "username" => DataHandleService::SanitizeInput($username), 
                "email" => $email,
                "email_verified" => false,
                "date_birth" => $date_of_birth,
                "status" => 0,
                "api_access" => false,
                "password" => DataHandleService::GetHashedPassword($password),
                "created_account" => date("Y-m-d", time())
            ))) {
                return null;
            }

            return $this->GetUserByUUID($uuid);
        }
    }
?>
