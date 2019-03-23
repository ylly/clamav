<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavScan\Client;

use YllyClamavScan\Exception\FailedSocketConnectionException;

class SocketClamavClient implements ClamavClientInterface
{
    // assume arbitrary value for huge scan
    const SOCKET_LENGTH = 200000;

    private $address;

    private $port;

    private $socketLength;

    public function __construct($address, $port, $socketLength)
    {
        $this->address = $address;
        $this->port = $port;
        $this->socketLength = null !== $socketLength ? $socketLength : self::SOCKET_LENGTH;
    }

    public function ping()
    {
        return $this->send('PING');
    }

    public function version()
    {
        return $this->send('VERSION');
    }

    public function scan($path)
    {
        return $this->send("SCAN {$path}");
    }

    public function contscan($path)
    {
        return $this->send("CONTSCAN {$path}");
    }

    public function multiscan($path)
    {
        return $this->send("MULTISCAN {$path}");
    }

    public function instream()
    {
        throw new \Exception('Not implement yet');
    }

    public function fildes()
    {
        throw new \Exception('Not implement yet');
    }

    public function stats()
    {
        throw new \Exception('Not implement yet');
    }

    public function versioncommands()
    {
        throw new \Exception('Not implement yet');
    }

    /**
     * @param string $command
     *
     * @throws FailedSocketConnectionException
     *
     * @return string
     */
    private function send($command)
    {
        $socket = socket_create($this->getSocketType(), SOCK_STREAM, 0);

        if (!@socket_connect($socket, $this->address, $this->port)) {
            throw new FailedSocketConnectionException($this->address, $this->port);
        }

        socket_send($socket, $command, \strlen($command), 0);
        socket_recv($socket, $return, $this->socketLength, MSG_WAITALL);
        socket_close($socket);

        return trim($return);
    }

    /**
     * @return int
     */
    private function getSocketType()
    {
        return (filter_var($this->address, FILTER_VALIDATE_IP) ||
            filter_var($this->address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? AF_INET : AF_UNIX;
    }
}
