<?php

namespace Zechim\ApiBundle\DependencyInjection;

use SimpleEncryptedText\OpenSSL;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Zechim\ApiBundle\Security\Credential\HeaderCredential;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zechim_api');

        $rootNode->children()
            ->arrayNode('builder')
                ->isRequired()
                ->children()
                    ->scalarNode('encrypt_class')->cannotBeEmpty()->defaultValue(OpenSSL::class)->end()
                    ->scalarNode('encrypt_key')->cannotBeEmpty()->end()
                    ->scalarNode('encrypt_cipher')->cannotBeOverwritten()->defaultValue('AES-256-CFB8')->end()
                    ->scalarNode('credential_name')->cannotBeEmpty()->defaultValue('app-token')->end()
                    ->scalarNode('credential_class')->cannotBeEmpty()->defaultValue(HeaderCredential::class)->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
