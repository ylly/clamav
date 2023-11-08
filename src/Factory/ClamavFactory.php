<?php

namespace YllyClamavScan\Factory;

use YllyClamavScan\Clamav;
use YllyClamavScan\Client\SocketClamavClient;
use YllyClamavScan\Configurator;

class ClamavFactory
{
    /**
     * @param string $address
     * @param int    $port
     * @param int    $socketLength
     *
     * @return Clamav
     */
    public static function create(string $address, int $port, int $socketLength)
    {
        $client = new SocketClamavClient($address, $port, $socketLength);

        return new Clamav($client);
    }

    /**
     * @param array $config
     *
     * @return Clamav
     */
    public static function createFromArray(array $config)
    {
        return self::create(
            $config['address'],
            $config['port'] ?? null,
            $config['socket_length'] ?? null
        );
    }

    /**
     * @param string $absolutePath
     *
     * @return Clamav
     */
    public static function createFromYamlFile($absolutePath)
    {
        $config = Configurator::loadFromFile($absolutePath);

        return self::createFromArray($config);
    }
}
