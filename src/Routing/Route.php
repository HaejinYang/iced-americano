<?php
namespace Thumbsupcat\IcedAmericano\Routing;

use Thumbsupcat\IcedAmericano\Routing\RequestContext;
use Thumbsupcat\IcedAmericano\Http\Request;

class Route
{
    private static array $contexts = [];

    public static function add($method, $path, $handler, $middlewares = [])
    {
        self::$contexts[] = new RequestContext($method, $path, $handler, $middlewares);
    }

    public static function run()
    {
        foreach (self::$contexts as $context) {
            if($context->method === strtolower(Request::getMethod()) && is_array($url_params = $context->match(Request::getPath()))){
                if ($context->runMiddleWare()) {
                    return \call_user_func($context->handler, ...$url_params);
                }

                return false;
            }
        }
    }
}