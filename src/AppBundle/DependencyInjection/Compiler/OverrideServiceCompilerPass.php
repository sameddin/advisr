<?php
namespace AppBundle\DependencyInjection\Compiler;

use App\Util\FixturesFinder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('hautelook_alice.doctrine.orm.fixtures_finder');
        $definition->setClass(FixturesFinder::class);
        $definition->addMethodCall('setRootDir', [$container->getParameter('kernel.root_dir')]);
    }
}
