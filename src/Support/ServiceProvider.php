<?php
namespace Thumbsupcat\IcedAmericano\Support;

/*
 * 데이터베이스 연결
 * 세션을 켜는 일
 * 에러 핸들러 등록하기
 * 환경 설정하기..
 * 이런 것들은 모두 서비스 프로바이더에서 한다.
 *
 */
interface ServiceProvider
{
    public static function register();
    public static function boot();
}