<?php
namespace Thumbsupcat\IcedAmericano\Routing;

/*
 * Route는 HTTP 요청을 등록하고 실행한다.
 * HTTP 메소드, 경로, 핸들러, 미들웨어는 하나의 RequestContext가 되어 Route에 등록된다.
 */
class RequestContext
{
    public string $path;
    public string $method;
    public $handler;
    public $middlewares;

    public function __construct($method, $path, $handler, $middlewares = [])
    {
        $this->method =$method;
        $this->path = $path;
        $this->handler = $handler;
        $this->middlewares = $middlewares;
    }

    /*
     *
     */
    public function match($url)
    {
        /*
         * $this->path  : /user, /user/{id}
         * $url         " /user, /user/1
         */

        $pattern_parts = explode("/",$this->path);
        $url_parts = explode("/", $url);

        if(count($pattern_parts) !==count($url_parts)) {
            return null;
        }

        $params = [];
        foreach ($pattern_parts as $key => $part) {
            if(preg_match('/^{.*}$/', $part)) {
                $params[] = $url_parts[$key];
            } else {
                /*
                 * /user/1 !== /users/1
                 */
                if($part !== $url_parts[$key]) {
                    return null;
                }
            }
        }

        return $params;
    }

    public function runMiddleware()
    {
        foreach ($this->middlewares as $middleware) {
            if (!$middleware::process()) {
                return false;
            }
        }

        return true;
    }
}