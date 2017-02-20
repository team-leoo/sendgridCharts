<?php
/** Namespace */
namespace LeooTeam\SendgridChartsBundle\DependencyInjection;

/** Usages */
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class LeooTeamSendgridChartsExtension
 * @package LeooTeam\SendgridChartsBundle\DependencyInjection
 */
class LeooTeamSendgridChartsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['client'])) {
            /** @todo configurable parameters */
            $config['guzzle']['clients'][$config['client']] = [
                'base_url' =>  'https://api.sendgrid.com/v3',
                'headers'  =>  [
                    'Accept' => 'application/json'
                ],
            ];
        }

        $container->setParameter('leoo_team_sendgrid_charts', $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
