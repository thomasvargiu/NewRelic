<?php
namespace NewRelicTest\TransactionNameProvider;

use NewRelic\TransactionNameProvider\RouteNameProvider;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RouteNameProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTransactionNameFromMvcEventWithoutRouteMatchShouldReturnNull()
    {
        $routeNameProvider = new RouteNameProvider();

        $event = new MvcEvent();
        $event->setRouteMatch(new RouteMatch([]));

        $transactionName = $routeNameProvider->getTransactionNameFromMvcEvent($event);

        $this->assertNull($transactionName);
    }

    public function testGetTransactionNameFromMvcEventWithRouteMatchShouldReturnRouteName()
    {
        $routeName = 'foo';
        $routeNameProvider = new RouteNameProvider();

        $routeMatch = new RouteMatch([]);
        $routeMatch->setMatchedRouteName($routeName);
        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);

        $transactionName = $routeNameProvider->getTransactionNameFromMvcEvent($event);

        $this->assertEquals($transactionName, $routeName);
    }
}
