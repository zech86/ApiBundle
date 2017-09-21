<?php


namespace Zechim\ApiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

class BuilderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->createEncryptDecryptService($container);
        $this->createCredentialFetcherService($container);
    }

    protected function createEncryptDecryptService(ContainerBuilder $container)
    {
        $definition = new Definition(new Parameter('zechim_api.builder_encrypt_class'));
        $definition->setArguments(
            [
                new Parameter('zechim_api.builder_encrypt_key'),
                new Parameter('zechim_api.builder_encrypt_cipher'),
            ]
        );

        $container->setDefinition('zechim_api.encrypt_decrypt', $definition);
    }

    protected function createCredentialFetcherService(ContainerBuilder $container)
    {
        $definition = new Definition(new Parameter('zechim_api.builder_credential_class'));
        $definition->setArguments(
            [
                new Parameter('zechim_api.builder_credential_name'),
                new Reference('zechim_api.encrypt_decrypt'),
            ]
        );

        $container->setDefinition('zechim_api.credential_fetcher', $definition);
    }
}
