<?php
namespace Thumbsupcat\IcedAmericano;

use Thumbsupcat\IcedAmericano\Support\ServiceProvider;

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