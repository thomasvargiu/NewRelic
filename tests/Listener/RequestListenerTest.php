<?php
namespace NewRelicTest\Listener;

use NewRelic\ClientInterface;
use NewRelic\Listener\RequestListener;
use NewRelic\ModuleOptions;
use NewRelic\TransactionNameProvider\TransactionNameProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RequestListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var TransactionNameProviderInterface
     */
    protected $transactionNameProvider;

    /**
     * @var RequestListener
     */
    protected $listener;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp()
    {
        $this->client = $this->getMock(ClientInterface::class);
        $this->moduleOptions = new ModuleOptions();
        $this->transactionNameProvider = $this->getMock(TransactionNameProviderInterface::class);
        $this->listener = new RequestListener(
            $this->client,
            $this->moduleOptions,
            $this->transactionNameProvider
        );

        $this->event = new MvcEvent();
    }

    public function testOnRequestWhenATransactionNameIsNotProvidedShouldNotCallNameTransactionMethod()
    {
        $transactionName = null;

        $this->transactionNameProvider
            ->expects($this->once())
            ->method('getTransactionNameFromMvcEvent')
            ->will($this->returnValue($transactionName));

        $this->client
            ->expects($this->never())
            ->method('nameTransaction');

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenATransactionNameIsProvidedShouldCallNameTransactionMethod()
    {
        $transactionName = 'foo';

        $this->transactionNameProvider
            ->expects($this->once())
            ->method('getTransactionNameFromMvcEvent')
            ->will($this->returnValue($transactionName));

        $this->client
            ->expects($this->once())
            ->method('nameTransaction')
            ->with($transactionName);

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenApplicationIsProvidedShouldSetAppName()
    {
        $applicationName = 'foo';
        $this->moduleOptions->setApplicationName($applicationName);

        $this->client
            ->expects($this->once())
            ->method('setAppName')
            ->with($applicationName, $this->anything());

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenApplicationIsNotProvidedShouldNotSetAppName()
    {
        $applicationName = '';
        $this->moduleOptions->setApplicationName($applicationName);

        $this->client
            ->expects($this->never())
            ->method('setAppName');

        $this->listener->onRequest($this->event);
    }
}
