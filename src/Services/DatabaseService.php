<?php namespace Services;
    use PDO;
    use mysqli;

    class DatabaseService {
        private static ?DatabaseService $instance = null;
        private array $connections = array();

        public static function GetInstance(): DatabaseService {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public static function PDOConnection(string $host, string $user, ?string $password = null, ?string $database = null): ?PDO {
            return DatabaseService::GetInstance()->PDOConnectionImplementation($host, $user, $password, $database);
        }

        public static function MySQLIConnection(string $host, string $user, ?string $password = null, ?string $database = null): ?mysqli {
            return DatabaseService::GetInstance()->MySQLIConnectionImplementation($host, $user, $password, $database);
        }

        public static function DeletePDOConnection(string $name): bool {
            return DatabaseService::GetInstance()->DeletePDOConnectionImplementation($name);
        }

        public static function DeleteMySQLIConnection(string $name): bool {
            return DatabaseService::GetInstance()->DeleteMySQLIConnectionImplementation($name);
        }

        public static function GetPDOConnection(string $name): ?PDO {
            return DatabaseService::GetInstance()->GetPDOConnectionImplementation($name);
        }

        public static function GetMySQLIConnection(string $name): ?mysqli {
            return DatabaseService::GetInstance()->GetMySQLIConnectionImplementation($name);
        }

        public static function MySQLICreateDatabase(string $name, string $database_name): bool {
            return DatabaseService::GetInstance()->MySQLICreateDatabaseImplementation($name, $database_name);
        }

        public static function MySQLIDropDatabase(string $name, string $database_name): bool {
            return DatabaseService::GetInstance()->MySQLIDropDatabaseImplementation($name, $database_name);
        }

        private function PDOConnectionImplementation(string $host, string $user, ?string $password = null, ?string $database = null): ?PDO {
            if (isset($this->connections["PDO:$host/$user/$database"])) {
                return $this->connections["PDO:$host/$user/$database"];
            }
           // var_dump($password);
            $connections["PDO:$host/$user/$database"] = new PDO("mysql:host=". $host. ";dbname=". $database, $user, $password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ));
            $connections["PDO:$host/$user/$database"]->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connections["PDO:$host/$user/$database"];
        }

        private function MySQLIConnectionImplementation(string $host, string $user, ?string $password = null, ?string $database = null): ?mysqli {
            if (isset($this->connections["MYSQLI:$host/$user". (isset($database) ? "/$database" : "")])) {
                return $this->connections["MYSQLI:$host/$user". (isset($database) ? "/$database" : "")];
            }

            $this->connections["MYSQLI:$host/$user". (isset($database) ? "/$database" : "")] = new mysqli($host, $user, $password, $database);
            //var_dump( $this->connections);
            return $this->connections["MYSQLI:$host/$user". (isset($database) ? "/$database" : "")];
        }

        private function DeletePDOConnectionImplementation(string $name): bool {
            if (!isset($this->connections["PDO:". $name])) {
                return false;
            }

            unset($this->connections["PDO:". $name]);

            return true;
        }

        private function DeleteMySQLIConnectionImplementation(string $name): bool {
            if (!isset($this->connections["MYSQLI:". $name])) {
                return false;
            }

            $this->connections["MYSQLI:". $name]->Close();
            unset($this->connections["MYSQLI:". $name]);

            return true;
        }

        private function GetPDOConnectionImplementation(string $name): ?PDO {
            if (!isset($this->connections["PDO:". $name])) {
                return null;
            }

            return $this->connections["PDO:". $name];
        }

        private function GetMySQLIConnectionImplementation(string $name): ?mysqli {
            if (!isset($this->connections["MYSQLI:". $name])) {
                return null;
            }

            return $this->connections["MYSQLI:". $name];
        }

        private function MySQLICreateDatabaseImplementation(string $name, string $database_name): bool {
            if (!isset($this->connections["MYSQLI:". $name])) {
                return false;
            }

            return $this->connections["MYSQLI:". $name]->Query("CREATE DATABASE IF NOT EXISTS `". $database_name. "` CHARACTER SET utf8 COLLATE utf8_general_ci;");
        }

        private function MySQLIDropDatabaseImplementation(string $name, string $database_name): bool {
            
            if (!isset($this->connections["MYSQLI:". $name])) {
                return false;
            }

            return $this->connections["MYSQLI:". $name]->Query("DROP DATABASE IF EXISTS `". $database_name. "`;");
        }
    }
?>
