<?php
namespace NewRelic\Factory;

use NewRelic\Listener\ResponseListener;

class ResponseListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');

        $transactionNameProvider = $serviceLocator->get(
            $options->getTransactionNameProvider()
        );

        return new ResponseListener($client, $options, $transactionNameProvider);
    }
}
