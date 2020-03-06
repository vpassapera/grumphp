<?php

declare(strict_types=1);

namespace GrumPHP\Configuration;

use GrumPHP\Exception\DeprecatedException;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class GrumPHPExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->loadInternal(
            $this->processConfiguration(
                $this->getConfiguration($configs, $container),
                $configs
            ),
            $container
        );
    }

    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration();
    }

    public function getAlias()
    {
        return 'grumphp';
    }

    private function loadInternal(array $config, ContainerBuilder $container): void
    {
        foreach ($config as $key => $value) {
            if ($container->hasParameter($key)) {
                throw DeprecatedException::directParameterConfiguration($key);
            }

            // TODO : instead of dynamic : set hardcoded! (Good for autocompletion)

            $container->setParameter($key, $value);
        }
    }
}
