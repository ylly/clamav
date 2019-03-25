<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
    public static function create($address, $port, $socketLength)
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
            isset($config['port']) ? $config['port'] : null,
            isset($config['socket_length']) ? $config['socket_length'] : null
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
