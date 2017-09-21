<?php

namespace Zechim\ApiBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zechim\ApiBundle\DependencyInjection\Compiler\BuilderCompilerPass;

class ZechimApiBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new BuilderCompilerPass());
    }
}
