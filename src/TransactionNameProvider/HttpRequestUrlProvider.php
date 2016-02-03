<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Http\Request;
use Zend\Mvc\MvcEvent;

class HttpRequestUrlProvider implements TransactionNameProviderInterface
{
    /**
     * {@inheritedDoc}
     */
    public function getTransactionNameFromMvcEvent(MvcEvent $event)
    {
        $request = $event->getRequest();
        if (!$request instanceof Request) {
            return null;
        }

        return $request->getUriString();
    }
}
