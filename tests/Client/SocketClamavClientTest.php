<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavTest;

use PHPUnit\Framework\TestCase;
use YllyClamavScan\Client\SocketClamavClient;

/**
 * @internal
 * @coversNothing
 */
final class SocketClamavClientTest extends TestCase
{
    /**
     * @dataProvider addressProvider
     *
     * @param mixed $excepted
     * @param mixed $address
     */
    public function testSocketType($excepted, $address)
    {
        $socketClamavSocket = new SocketClamavClient($address, 0, null);

        $this->assertSame($excepted, $this->invokeMethod($socketClamavSocket, 'getSocketType'));
    }

    public function addressProvider()
    {
        return [
            [AF_INET, '192.168.0.1'],
            [AF_INET, '54.18.100.1'],
            [AF_INET, '2001:0db8:0000:85a3:0000:0000:ac1f:8001'],
            [AF_INET, '2001:db8:0:85a3::ac1f:8001'],
            [AF_UNIX, 'unix://var/run/clamav.sock'],
        ];
    }

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
