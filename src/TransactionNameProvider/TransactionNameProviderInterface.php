<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

interface TransactionNameProviderInterface
{
    /**
     * @param  MvcEvent $event
     * @return string
     */
    public function getTransactionNameFromMvcEvent(MvcEvent $event);
}
