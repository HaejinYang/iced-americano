<?php

namespace Thumbsupcat\IcedAmericano\Routing;

/*
 * 미들웨어를 실행하는 주체는 RequestContext이다.
 * 미들웨어는 라우터에 등록되어 컨트롤러 이전에 호출된다.
 * 로그인이 되었는지 거르거나, 미리 정의된 데이터가 빠지진 않았는지(토큰, 헤더 등)를 확인하고 거른다.
 */
abstract class Middleware
{
    abstract public static function process();
}