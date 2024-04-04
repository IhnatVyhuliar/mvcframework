<?php namespace Services;
    class DataHandleService {
        public static function SanitizeInput(string $data): string {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }
        
        public static function ValidateInputData(array $values): bool {
            foreach ($values as $key => $value) {
                switch ($key) {
                    case "username":
                        if (!is_string($value)) {
                            return false;
                        }

                        if (trim($value) !== DataHandleService::SanitizeInput($value)) {
                            return false;
                        }

                        if ($value !== strtolower($value)) {
                            return false;
                        }

                        if (strlen($value) < 3 || strlen($value) > 18) {
                            return false;
                        }
                        
                        if (preg_match("/[|\\/~^`:\",;:?!()\[\]{}<>'&%$@*+-=\.]/", $value)) {
                            return false;
                        }

                        if (preg_match("/[0-9]/", $value)){
                            return false;
                        }
                        
                        if (preg_match("/[żźćńółęąśŻŹĆĄŚĘŁÓŃ]/", $value)){
                            return false;
                        }

                        break;

                    case "email":
                        
                        break;

                    case "password":
                        break;

                    default:
                        break;
                }
            }
        }
        public static function CheckEmal($email):bool{
            return !filter_var($email, FILTER_VALIDATE_EMAIL);   
        }
        public static function GetHashedPassword(string $password): string {
            return password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
        }

        public static function CheckPassword(string $password, string $hash): bool {
            return password_verify($password, $hash);
        }

        public static function GetLink(): string {
            return isset($_SERVER['HTTPS']) ? 'https://' : 'http://'. $_SERVER['HTTP_HOST'];
        }

        public static function ValidateData(array $data, array $expected_data): bool {
            if (sizeof($data) !== sizeof($expected_data)) {
                return false;
            }
            $keys=array_keys($data);
            for ($i = 0; $i < sizeof($expected_data); $i++) { 
                $el = $expected_data[$keys[$i]];
                $data_got = $data[$keys[$i]];
                
                if (isset($el["type"])) {
                    switch ($el["type"]) {
                        case "array":
                            if (!DataHandleService::ValidateData($data_got, $el)) {
                                return false;
                            }

                        case "bool":
                            if (!is_bool($data_got)) {
                                return false;
                            }

                            break;
                        case "int":
                            if (!is_numeric($data_got)) {
                                return false;
                            }

                            break;
                        case "string":
                            if (!is_string($data_got)) {
                                return false;
                            }
                        
                    
                    }
                }
                
                if (isset($el["length"])){
                    $range=$el["length"];
                    //var_dump(strlen(strval($data_got)));
                    if (strlen(strval($data_got)) < $range[0] || strlen(strval($data_got)) > $range[1]) {
                        return false;
                    }
                    
                }

                if (isset($el["length_arr"])){
                    $range=$el["length"];
                    //var_dump(strlen(strval($data_got)));
                    if (sizeof($data_got) < $range[0] ||sizeof($data_got)  > $range[1]) {
                        return false;
                    }
                    
                }
            }

            /*var_dump(DataHandleService::ValidateData($_GET, array(
                "teacher" => array(
                    "type" => "string",
                    "lenght" => array(1,30),
                ),
                "mother" => array(
                    "type" => "int"
                )
            )));*/


            return true;
        }
    }
?>
