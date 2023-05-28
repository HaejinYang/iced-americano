<?php
namespace Thumbsupcat\IcedAmericano;

use Thumbsupcat\IcedAmericano\Support\ServiceProvider;

class Application
{
    private $providers = [];

    public function __construct($providers = [])
    {
        $this->providers = $providers;
        array_walk($this->providers, fn ($provider) => $provider->register());
    }

    public function boot()
    {
        array_walk($this->providers, fn ($provider) => $provider->boot());
    }
}

/*
 * 왜 이러한 구조인가...
 * 데이터베이스 연결
 * 세션을 켜는 일
 * 에러 핸들러 등록하기
 * 환경 설정하기..
 * 이런 것들은 모두 서비스 프로바이더에서 한다.
 *
 */

use Thumbsupcat\IcedAmericano\Support\ServiceProvider;
use Thumbsupcat\IcedAmericano\Application;

class SessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //session_set_save_handler
    }

    public function boot()
    {
        session_start();
    }
}

// 라우트 서비스 프로바이더 라라벨의 서비스 컨테이너에 영향을 받음.
// ...

$app = new Application([
    SessionServiceProvider::class
]);

$app->boot();