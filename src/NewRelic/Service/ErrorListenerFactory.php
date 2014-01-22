<?php
namespace NewRelic\Service;

use NewRelic\Listener\ErrorListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic error listener factory
 */
class ErrorListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ErrorListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->get('NewRelic\Client');
        $logger = $serviceLocator->get('NewRelic\ExceptionLogger');

        return new ErrorListener($client, $logger);
    }
}