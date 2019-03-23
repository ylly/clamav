<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavTest;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use YllyClamavScan\Clamav;
use YllyClamavScan\Client\SocketClamavClient;
use YllyClamavScan\Exception\FailedSocketConnectionException;
use YllyClamavScan\Exception\FileNotFoundException;

/**
 * @internal
 * @coversNothing
 */
final class ClamavTest extends TestCase
{
    protected $path;

    protected function setUp()
    {
        vfsStream::setup();
        $this->path = vfsStream::url('root/clamav.sock');
    }

    public function testPingAvailable()
    {
        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $socketClamavProphecy
            ->ping()
            ->shouldBeCalled(1)
            ->willReturn('PONG')
        ;

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $this->assertTrue($clamav->isAvailable());
    }

    public function testPingUnavailable()
    {
        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $socketClamavProphecy
            ->ping()
            ->shouldBeCalled(1)
            ->willThrow(new FailedSocketConnectionException('unix://test'))
        ;

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $this->assertFalse($clamav->isAvailable());
    }

    public function testPingUnknowError()
    {
        $this->expectException(\Exception::class);

        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $socketClamavProphecy
            ->ping()
            ->shouldBeCalled(1)
            ->willThrow(new \Exception('Error'))
        ;

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $clamav->isAvailable();
    }

    public function testVersion()
    {
        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $socketClamavProphecy
            ->version()
            ->shouldBeCalled(1)
            ->willReturn('ClamAV version 0.100')
        ;

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $this->assertSame($clamav->getVersion(), 'ClamAV version 0.100');
    }

    public function testScanParamsThrowLogicException()
    {
        $this->expectException(\LogicException::class);

        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $clamav->scanPath('/test', false, true);
    }

    public function testScanPathNotExist()
    {
        $this->expectException(FileNotFoundException::class);

        $socketClamavProphecy = $this->prophesize(SocketClamavClient::class);

        $clamav = new Clamav($socketClamavProphecy->reveal());

        $clamav->scanPath($this->path);
    }
}
