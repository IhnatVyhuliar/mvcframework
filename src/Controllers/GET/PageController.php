<?php namespace Controllers\GET;
    class PageController {
        public static function GetModifiedPage(string $filename, array $modifiers): string {
           $page = file_get_contents('./src/Views/'. $filename);

            foreach ($modifiers as $key => $value) {
                $page = str_replace($key, $value, $page);
            }

           return $page;
        }
    }
?>
