<?php

namespace SC\DatetimepickerBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages bundle configuration
 */
class SCDatetimepickerExtension extends Extension
{
    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configs = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twig.xml');
        $loader->load('datetime.xml');

        if (isset($configs["picker"]) && !empty($configs["picker"]['enabled'])) {
            $method = 'register' . ucfirst("picker") . 'Configuration';

            $this->$method($configs["picker"], $container);
        }

    }

    /**
     * Loads Picker configuration
     *
     * @param array $configs
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    private function registerPickerConfiguration(array $configs, ContainerBuilder $container): void
    {
        $container->setParameter('sc_datetimepicker.form.options', $configs['configs']);
    }
}
