<?php
namespace Thumbsupcat\IcedAmericano;

use Thumbsupcat\IcedAmericano\Support\ServiceProvider;

/*
 * Application은 Provider(라라벨의 컨테이너와 유사)를 순서대로 등록하고 순서대로 실행한다.
 * Provider는 프로젝트에서 사용할 기능을 제공하는 것이다.
 * 내장된 기능이란 거의 없어서, Provider를 받아서 등록하고 실행하는 큰 껍데기이다.
 */
class Application
{
    private $providers = [];

    public function __construct($providers = [])
    {
        $this->providers = $providers;
        array_walk($this->providers, fn ($provider) => $provider::register());
    }

    public function boot()
    {
        array_walk($this->providers, fn ($provider) => $provider::boot());
    }
}