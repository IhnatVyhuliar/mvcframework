<?php namespace Controllers\GET;
    use Databases\IndexDatabase;
    use Databases\SQLLauncher;
    use Log\Logger;
    use Exception;

    class ConfigController {
        public static function GetPage(): void {
            try {
                $index_database = new IndexDatabase();
                $index_database->InitDB($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    
                $sql_launcher = new SQLLauncher($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
                $sql_launcher->LaunchColumns('Users.sql');
            } catch (Exception $exception) {
                Logger::GetInstance()->Error(Logger::GetData($exception));
            }
        }
    }
?>
