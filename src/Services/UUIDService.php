<?php namespace Services;
    use Services\QueryService;

    class UUIDService {
        // 2014-703330-24KFUM-34DEJM-831FLF
        public static function GetUUID(): string {        
            $uuid = "";
            $uuid_control_sum = "";
            
            for ($i = 0; $i < 4; $i++) {
                if ($i != 0) {
                    $uuid .= "-";
                }
                //12
                //2014-703330-24KFUM-34DEJM-831FLF   random 7  control 0 
                $random_number = rand(0, 9);
                $control_number = rand(0, 12);
                $uuid_control_sum_cache = $control_number;
                $uuid .= $random_number. $control_number;
                var_dump(12 - $control_number);
                for ($j = 0; $j < 12 - $control_number; $j++) {
                    $random_number_cache = rand(0, 9);
                    $uuid .= $random_number_cache;
                    $uuid_control_sum_cache += $random_number_cache;
                }

                for($j = 0; $j < $control_number; $j++) {
                    $uuid .= chr(rand(65, 90));
                }

                $uuid_control_sum .= $random_number !== 0 ? $uuid_control_sum_cache % $random_number : 0;
            }

            return $uuid_control_sum. "-". $uuid;
        }

        public static function GetUniqueUUID(string $table): string {
            $uuid = UUIDService::GetUUID();
            
            while(UUIDService::CheckIfUUIDExistsInTable($uuid, $table)) {
                $uuid = UUIDService::GetUUID();
            }
            
            return $uuid;
        }

        public static function CheckUUID(string $uuid): bool {
            $numbers = str_split(substr($uuid, 0, 4));
            $uuid = str_replace("-", "", $uuid);
            $uuid_array = str_split(substr($uuid, 4, strlen($uuid)), 6);

            for ($i=0; $i < sizeof($uuid_array);$i++){
                $number_control = intval($numbers[$i]);
                $number_checks = $uuid_array[$i];

                $sum1 = 0;

                for($j = 1; $j < strlen($number_checks); $j++) {
                    $sum1 += intval(is_numeric($number_checks[$j]) ? $number_checks[$j] : 0);
                }

                if ($number_control !== (intval($number_checks[0]) !== 0 ? $sum1 % $number_checks[0] : 0)) {
                    return false;
                }
            }
            
            return true;
        }

        public static function CompareUUID(string $first_uuid, string $second_uuid): bool {
            return $first_uuid === $second_uuid;
        }

        public static function CheckIfUUIDExistsInTable(string $uuid, string $table): ?bool {
            if (!UUIDService::CheckUUID($uuid)){
                return null;
            }

            return QueryService::GetInstance()->CheckIfExists($table, array("uuid" => $uuid));
        }
    }
?>
