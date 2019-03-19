<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Server\Configurator;

use K911\Swoole\Server\Configurator\WithServerManagerStartHandler;
use K911\Swoole\Server\LifecycleHandler\NoOpServerManagerStartHandler;
use K911\Swoole\Tests\Unit\Server\SwooleHttpServerMock;
use PHPUnit\Framework\TestCase;

class WithServerManagerStartHandlerTest extends TestCase
{
    /**
     * @var NoOpServerManagerStartHandler
     */
    private $noOpServerManagerStartHandler;

    /**
     * @var WithServerManagerStartHandler
     */
    private $configurator;

    protected function setUp(): void
    {
        $this->noOpServerManagerStartHandler = new NoOpServerManagerStartHandler();

        $this->configurator = new WithServerManagerStartHandler($this->noOpServerManagerStartHandler);
    }

    public function testConfigure(): void
    {
        $swooleServerOnEventSpy = new SwooleHttpServerMock();

        $this->configurator->configure($swooleServerOnEventSpy);

        $this->assertTrue($swooleServerOnEventSpy->registeredEvent);
        $this->assertSame(['ManagerStart', [$this->noOpServerManagerStartHandler, 'handle']], $swooleServerOnEventSpy->registeredEventPair);
    }
}