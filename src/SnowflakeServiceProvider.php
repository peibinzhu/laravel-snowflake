<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;
use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;
use PeibinLaravel\Snowflake\Contracts\IdGeneratorInterface;
use PeibinLaravel\Snowflake\Contracts\MetaGeneratorInterface;
use PeibinLaravel\Snowflake\IdGenerator\SnowflakeIdGenerator;

class SnowflakeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $dependencies = [
            ConfigurationInterface::class => Configuration::class,
            IdGeneratorInterface::class   => SnowflakeIdGenerator::class,
            MetaGeneratorInterface::class => MetaGeneratorFactory::class,
        ];
        $this->registerDependencies($dependencies);

        $this->registerPublishing();
    }

    private function registerDependencies(array $dependencies)
    {
        $config = $this->app->get(Repository::class);
        foreach ($dependencies as $abstract => $concrete) {
            $concreteStr = is_string($concrete) ? $concrete : gettype($concrete);
            if (is_string($concrete) && method_exists($concrete, '__invoke')) {
                $concrete = function () use ($concrete) {
                    return $this->app->call($concrete . '@__invoke');
                };
            }
            $this->app->singleton($abstract, $concrete);
            $config->set(sprintf('dependencies.%s', $abstract), $concreteStr);
        }
    }

    public function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/snowflake.php' => config_path('snowflake.php'),
            ], 'snowflake');
        }
    }
}
