<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use Sonata\DoctrineORMAdminBundle\DependencyInjection\SonataDoctrineORMAdminExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SonataDoctrineORMAdminExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $configuration;

    protected function tearDown()
    {
        unset($this->configuration);
    }

    public function testEntityManagerSetFactory()
    {
        $this->configuration = new ContainerBuilder();
        $this->configuration->setParameter('kernel.bundles', []);
        $loader = new SonataDoctrineORMAdminExtension();
        $loader->load([], $this->configuration);

        $definition = $this->configuration->getDefinition('sonata.admin.entity_manager');
        $doctrineServiceId = 'doctrine';
        $doctrineFactoryMethod = 'getEntityManager';

        if (method_exists($definition, 'getFactory')) {
            $this->assertEquals([new Reference($doctrineServiceId), $doctrineFactoryMethod], $definition->getFactory());
        } else {
            $this->assertEquals($doctrineServiceId, $definition->getFactoryService());
            $this->assertEquals($doctrineFactoryMethod, $definition->getFactoryMethod());
        }
    }
}
