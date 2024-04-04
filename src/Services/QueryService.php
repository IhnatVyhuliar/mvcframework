<?php namespace Services;
    use Log\Logger;
    use PDO;
    
    class QueryService {
        private static ?QueryService $instance = null;
        private ?PDO $connection = null;

        public static function GetInstance(): QueryService {
            if (is_null(self::$instance)) {
                self::$instance = new QueryService();
            }

            return self::$instance;
        }

        public static function EstablishConnection(string $host, string $user, ?string $password = null, ?string $database = null): bool {
            return QueryService::GetInstance()->EstablishConnectionImplementation($host, $user, $password, $database);
        }

        public static function SpecificSQL(string $sql): bool {
            return QueryService::GetInstance()->SpecificSQLImplementation($sql);
        }

        public static function GetData(string $table, array $columns, array $values, bool $specific = true): ?array {
            return QueryService::GetInstance()->GetDataImplementation($table, $columns, $values, $specific);
        }

        public static function GetDataWithSpecificSQL(string $sql, array $values): ?array {
            return QueryService::GetInstance()->GetDataWithSpecificSQLImplementation($sql, $values);
        }

        public static function InsertData(string $table, array $values): bool {
            return QueryService::GetInstance()->InsertDataImplementation($table, $values);
        }

        public static function UpdateData(string $table, array $columns, array $values, bool $specific = true): bool {
            return QueryService::GetInstance()->UpdateDataImplementation($table, $columns, $values, $specific);
        }

        public static function DeleteData(string $table, array $values, bool $specific = true): bool {
            return QueryService::GetInstance()->DeleteDataImplementation($table, $values, $specific);
        }

        public static function CheckIfExists(string $table, array $values, bool $specific = true): ?bool {
            return QueryService::GetInstance()->CheckIfExistsImplementation($table, $values, $specific);
        }

        private function EstablishConnectionImplementation(string $host, string $user, ?string $password = null, ?string $database = null): bool {
            if (!isset($this->connection)) {
                $this->connection = DatabaseService::PDOConnection($host, $user, $password, $database);
            }

            return isset($this->connection);
        }

        private function CheckIfConnectionEstablished(): bool {
            if (!isset($this->connection)) {
                Logger::GetInstance()->Error(array("message" => "PDO is not initialized!"));

                return false;
            }

            return true;
        }

        private function SpecificSQLImplementation(string $sql): bool {
            if (!$this->CheckIfConnectionEstablished()) {
                return false;
            }
        
            $query = $this->connection->Prepare($sql);

            return $query->Execute();
        }

        private function CreateSQLQuery(string $type, bool $restricted, string $table, array $columns, array $values): string {
            $sql = "";

            switch ($type) {
                case "SELECT":
                    $sql .= "SELECT ". implode(", ", array_map(function($column) use ($table) {
                        return "$table.$column";
                    }, $columns)). " FROM `$table`". " WHERE ". implode($restricted ? " AND " : " OR ", array_map(function($column) use ($table) {
                        return "$table.$column = :$column";
                    }, array_keys($values))). ";";

                    break;
                    
                case "INSERT":
                    $sql .= "INSERT INTO `$table` (". implode(", ", array_map(function($column) use ($table) {
                        return "$table.$column";
                    }, array_keys($values))). ") VALUES (". implode(",", array_map(function($column) {
                        return ":$column";
                    }, array_keys($values))). ")";

                    break;
                    
                case "UPDATE":
                    $sql .= "UPDATE `$table` SET ". implode(", ", array_map(function($column) use ($table) {
                        return "$table.$column = :$column";
                    }, $columns)). " WHERE ". implode($restricted ? " AND " : " OR ", array_map(function($column) use ($table) {
                        return "$table.$column = :$column";
                    }, array_keys($values))). ";";

                    break;
                    
                case "DELETE":
                    $sql .= "DELETE FROM `$table`". " WHERE ". implode($restricted ? " AND " : " OR ", array_map(function($column) use ($table) {
                        return "$table.$column = :$column";
                    }, array_keys($values))). ";";
                    
                    break;
            }
            
            return $sql;
        }

        private function GetDataImplementation(string $table, array $columns, array $values, bool $specific = true): ?array {
            if (!$this->CheckIfConnectionEstablished()) {
                return null;
            }
        
            $query = $this->connection->Prepare($this->CreateSQLQuery("SELECT", $specific, $table, $columns, $values));
        
            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }
        
            if (!$query->Execute()) {
                return null;
            }
        
            return $query->FetchAll(PDO::FETCH_ASSOC);
        }

        private function GetDataWithSpecificSQLImplementation(string $sql, array $values): ?array {
            if (!$this->CheckIfConnectionEstablished()) {
                return null;
            }

            $query = $this->connection->Prepare($sql);

            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }

            if (!$query->Execute()) {
                return null;
            }

            return $query->FetchAll(PDO::FETCH_ASSOC);
        }

        private function InsertDataImplementation(string $table, array $values): bool {
            if (!$this->CheckIfConnectionEstablished()) {
                return false;
            }

            $query = $this->connection->Prepare($this->CreateSQLQuery("INSERT", true, $table, array(), $values));
            
            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }
        
            return $query->Execute();
        }

        private function UpdateDataImplementation(string $table, array $columns, array $values, bool $specific = true): bool {
            if (!$this->CheckIfConnectionEstablished()) {
                return false;
            }

            $query = $this->connection->Prepare($this->CreateSQLQuery("UPDATE", $specific, $table, $columns, $values));
        
            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }
        
            return $query->Execute();
        }

        private function DeleteDataImplementation(string $table, array $values, bool $specific = true): bool {
            if (!$this->CheckIfConnectionEstablished()) {
                return false;
            }
            
            $query = $this->connection->Prepare($this->CreateSQLQuery("DELETE", $specific, $table, array(), $values));

            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }
        
            return $query->Execute();
        }

        private function CheckIfExistsImplementation(string $table, array $values, bool $specific = true): ?bool {
            if (!$this->CheckIfConnectionEstablished()) {
                return null;
            }
            
            $query = $this->connection->Prepare($this->CreateSQLQuery("SELECT", $specific, $table, array("uuid"), $values));
        
            foreach ($values as $key => $value) {
                $query->BindValue(":$key", $value);
            }
        
            if (!$query->Execute()) {
                return null;
            }
            
            return sizeof($query->FetchAll(PDO::FETCH_ASSOC)) !== 0;
        }
    }
?>
