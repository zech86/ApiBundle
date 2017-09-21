<?php

namespace Zechim\ApiBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use SimpleEncryptedText\EncryptDecryptInterface;
use SimpleEncryptedText\OpenSSL;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Zechim\ApiBundle\Annotation\DecodeRequest;

final class RequestDecoderListener
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var EncryptDecryptInterface
     */
    private $encoder;

    public function __construct(Reader $reader, EncryptDecryptInterface $encoder)
    {
        $this->reader = $reader;
        $this->encoder = $encoder;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (false === $event->isMasterRequest()) {
            return;
        }

        $controller = $event->getController();

        if (false === is_array($controller)) {
            return null;
        }

        $method = new \ReflectionMethod($controller[0], $controller[1]);

        if (false === $this->hasDecoderAnnotation($method)) {
            return null;
        }

        $request = $event->getRequest();
        $request->request->set('decoded_content', $this->encoder->decode($request->getContent()));
    }

    /**
     * @param \ReflectionMethod $method
     * @return bool
     */
    protected function hasDecoderAnnotation(\ReflectionMethod $method)
    {
        foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
            if (true === $annotation instanceof DecodeRequest) {
                return true;
            }
        }

        return false;
    }

}