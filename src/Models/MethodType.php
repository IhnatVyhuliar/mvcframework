<?php namespace Models;
    enum MethodType {
        case None;
        case GET;
        case POST;
        case DELETE;
        case PUT;

        public static function MethodTypeFromString(string $type): MethodType {
            return match($type) {
                ""  => MethodType::None,   
                "GET" => MethodType::GET,   
                "POST" => MethodType::POST,
                "DELETE" => MethodType::DELETE,
                "PUT" => MethodType::PUT
            };
        }

        public static function StringFromMethodType(MethodType $type): string {
            return match($type) {
                MethodType::None => "",   
                MethodType::GET => "GET",   
                MethodType::POST => "POST",
                MethodType::DELETE => "DELETE",
                MethodType::PUT => "PUT"
            };
        }
    }
?>
