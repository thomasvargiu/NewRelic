<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RouteNameProvider implements TransactionNameProviderInterface
{
    /**
     * {@inheritedDoc}
     */
    public function getTransactionNameFromMvcEvent(MvcEvent $event)
    {
        $matches = $event->getRouteMatch();
        if (!$matches instanceof RouteMatch) {
            return null;
        }

        return $matches->getMatchedRouteName();
    }
}
