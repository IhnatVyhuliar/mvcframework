<?php namespace Routes\Website;
    use ArrayObject;
    use Models\MethodType;

    class Router {
        private ?array $routes = null;
        private ?array $allowed_extensions = null;

        public function __construct() {
            $this->routes = array();
            $this->allowed_extensions = array(
                "js", "css", "html",
                "png", "ico", "svg", "jpg", "tiff", "gif", "jpeg", "ttf", "webp", "avif",
                "mp4", "mp4a", "mp4p", "mp4b", "mp4r", "mp4v", "mov",
                "movie", "qt", "wave", "wav",
                "svg", "ttf", "oft", "woff", "woff2"
            );
        }
        
        public function GET(string $url, string $controller): void {
            $this->routes[] = array(
                "url" => $url,
                "pathinfo" => pathinfo($url),
                "controller" => $controller,
                "method" => MethodType::GET
            );
        }
        
        public function POST(string $url, string $controller): void {
            $this->routes[] = array(
                "url" => $url,
                "pathinfo" => pathinfo($url),
                "controller" => $controller,
                "method" => MethodType::POST
            );
        }

        public function DELETE(string $url, string $controller): void {
            $this->routes[] = array(
                "url" => $url,
                "pathinfo" => pathinfo($url),
                "controller" => $controller,
                "method" => MethodType::DELETE
            );
        }

        public function PUT(string $url, string $controller): void {
            $this->routes[] = array(
                "url" => $url,
                "pathinfo" => pathinfo($url),
                "controller" => $controller,
                "method" => MethodType::PUT
            );
        }

        public function Route(string $url, MethodType $method): void {
            foreach ($this->routes as $route) {
                if ($route["method"] !== $method) {
                    continue;
                }

                if ($route["pathinfo"]["filename"] !== pathinfo($url)["filename"] && $route["pathinfo"]["filename"] !== "*") {
                    continue;
                }

                if (isset(pathinfo($url)["extension"]) && !in_array(pathinfo($url)["extension"], $this->allowed_extensions) && $route["pathinfo"]["extension"] !== "*") {
                    continue;
                }

                if ($route["pathinfo"]["dirname"] !== pathinfo($url)["dirname"]) {
                    continue;
                }

                $route["controller"]::Trigger($url);

                return;
            }

            $this->Abort(404);
        }

        private function Abort(int $code): void {
            http_response_code($code);

            die();
        }
    }
?>
