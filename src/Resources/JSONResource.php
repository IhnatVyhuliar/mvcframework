<?php namespace Resources;
    class JSONResource {
        public static function GetJSONFormat(bool $success, string $message, array $content = array()): string {
            return json_encode(array(
                "success" => $success,
                "message" => $message,
                "content" => sizeof($content) > 1 ? $content : null
            ));
        }
    }
?>
