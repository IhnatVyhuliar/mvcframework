<?php namespace Databases;
    use Services\DatabaseService;

    class DatabaseInitializer {
        public static function InitDatabase(string $host, string $user, ?string $password = null): void {
            DatabaseService::MySQLIConnection($host, $user, $password);
            
            DatabaseService::MySQLIDropDatabase("$host/$user", "firespark");
            DatabaseService::MySQLICreateDatabase("$host/$user", "firespark");
            DatabaseService::DeleteMySQLIConnection("$host/$user");
        }
    }
?>
