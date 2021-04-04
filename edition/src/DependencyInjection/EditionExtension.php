<?php

namespace Edition\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use Edition\EntityBase\Post as BasePost;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Parser as YamlParser;

class EditionExtension extends Extension implements PrependExtensionInterface
//    , CompilerPassInterface
{

    const DOCTRINE_CONFIG = __DIR__ . '/../Resources/config/packages/doctrine.yaml';
    const DOCTRINE_RESOLVER = 'doctrine.orm.listeners.resolve_target_entity';

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'doctrine',
            $this->getDoctrineConfig()
        );
    }

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
    }

    public function process(ContainerBuilder $container)
    {
        $em = $container->findDefinition(EntityManagerInterface::class);

        $resolverCalls = $container
            ->findDefinition(static::DOCTRINE_RESOLVER)
            ->getMethodCalls();

        foreach ($resolverCalls as [$method, [$base, $entity]]) {
            $method == 'addResolveTargetEntity'
                && is_a($base, BasePost::class, true)
                && $em->addMethodCall('getClassMetadata', [$entity]);
        }
    }

    private function getDoctrineConfig()
    {
        return (new YamlParser())
            ->parseFile(static::DOCTRINE_CONFIG)
            ['doctrine'];
    }

}
