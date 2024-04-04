<?php namespace Databases;

use Services\DatabaseService;
use Services\QueryService;

   class SQLLauncher {
      public static function LaunchColumns(string $filepath, string $host, string $user, ?string $password = null, string $database): bool {
         $filepath = "./src/Databases/SQL/". $filepath;

         $file = fopen($filepath, 'r');
         $content = fread($file, filesize($filepath));
         fclose($file);
         
         QueryService::EstablishConnection($host, $user, $password, $database);

         return QueryService::SpecificSQL($content);
      }
   }
?>
