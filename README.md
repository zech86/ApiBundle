Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require zech86/api-bundle dev-master
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Zechim\ApiBundle\ZechimApiBundle(),
        );
        // ...
    }
    
    // ...
}
```

Step 3: Enable the Token Authenticator
--------------------------------------

```yaml
# in security.yml
security:
  ...
  firewalls:
    your_firewall_name:
      pattern:  ^/pattern_to_be_authenticated
      anonymous: ~
      guard:
        authenticators:
          - zechim_api.token_authenticator
          
  access_control:
    - { path: ^/pattern_to_be_authenticated, roles: IS_AUTHENTICATED_FULLY }
```

Step 3: Configuration
--------------------------------------

```yaml
zechim_api:
  builder:
    # default
    encrypt_class: SimpleEncryptedText/OpenSSL
    # required
    encrypt_key: your secret key
    # http://php.net/manual/pt_BR/function.openssl-get-cipher-methods.php
    # default
    encrypt_cipher: AES-256-CFB8
    # default
    credential_name: app-token
    # default
    credential_class: Zechim\ApiBundle\Security\Credential\HeaderCredential
```