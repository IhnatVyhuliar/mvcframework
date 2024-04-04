<?php namespace Models;
    use Models\Status;

    class User {
        private string $uuid;
        private string $name;
        private string $surname;
        private string $username;
        private string $email;
        private bool $email_verified;
        private string $date_birth;
        private Status $status;
        private bool $api_access;
        private string|null $password;
        private string $created_account;

        public function __construct(string $uuid, string $name, string $surname, string $username, string $email, bool $email_verified, string $date_birth, Status $status, bool $api_access, string|null $password = null, string $created_account) {
            $this->uuid = $uuid;
            $this->name = $name;
            $this->surname = $surname;
            $this->username = $username;
            $this->email = $email;
            $this->email_verified = $email_verified;
            $this->date_birth = $date_birth;
            $this->status = $status;
            $this->api_access = $api_access;
            $this->password = $password ?? null;
            $this->created_account = $created_account;
        }

        public function GetData(): array {
            return array(
                "uuid" => $this->uuid,
                "name" => $this->name,
                "surname"=>$this->surname,
                "username"=>$this->username,                    
                "emali" => $this->email,
                "email_verified" => $this->email_verified,
                "date_birth"=> $this->date_birth,
                "status" => Status::StringFromStatusType($this->status),
                "api_access" => $this->api_access,
                "password" => $this->password ?? null,
                "created_account"=> $this->created_account
            );
        }

        public function GetUUID(): string {
            return $this->uuid;
        }

        public function GetName(): string {
            return $this->name;
        }

        public function GetSurname(): string {
            return $this->surname;
        }

        public function GetUsername(): string {
            return $this->username;
        }

        public function GetEmail(): string {
            return $this->email;
        }

        public function GetEmailVerified(): bool {
            return $this->email_verified;
        }

        public function GetDateBirth(): string {
            return $this->date_birth;
        }

        public function GetStatus(): Status {
            return $this->status;
        }

        public function GetAPIAccess(): bool {
            return $this->api_access;
        }

        public function GetPassword(): string {
            return $this->password;
        }

        public function GetCreatedAccount(): string {
            return $this->created_account;
        }
    }
?>
