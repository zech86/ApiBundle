<?php

namespace Zechim\ApiBundle\Security\Credential;

final class Credential implements CredentialInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * Credential constructor.
     * @param $value
     */
    public function __construct(array $data)
    {
        if (0 === count($data)) {
            throw new \InvalidArgumentException('credential must not be empty');
        }

        $data = array_merge(['username' => null], $data);

        $this->username = $data['username'];
    }

    public function getUsername()
    {
        return $this->username;
    }
}