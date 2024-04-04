<?php
    use Databases\DatabaseInitializer;
    use Databases\SQLLauncher;
    use Dotenv\Dotenv;
    use Log\Logger;

    require_once(__DIR__. "/vendor/autoload.php");

    function main(array $args = array(), array $kwargs = array()): int {
        $dotenv = Dotenv::CreateImmutable(__DIR__);
        $dotenv->Load();

        DatabaseInitializer::InitDatabase($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        SQLLauncher::LaunchColumns("Database.sql", $_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

        return 0;
    }

    main();
?>
