<?php
namespace Thumbsupcat\IcedAmericano\Http;

class Request
{
    public static function getMethod()
    {
        return filter_input(INPUT_POST, '_method') ?: $_SERVER['REQUEST_METHOD'];
    }

    public static function getPath()
    {
        return $_SERVER['PATH_INFO'] ?? '/';
    }
}