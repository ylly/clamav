<?php

namespace YllyClamavTest;

use PHPUnit\Framework\TestCase;
use YllyClamavScan\Client\SocketClamavClient;

final class SocketClamavClientTest extends TestCase
{
    /**
     * @dataProvider addressProvider
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
