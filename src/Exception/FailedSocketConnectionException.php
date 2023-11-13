<?php

namespace YllyClamavScan\Exception;

final class FailedSocketConnectionException extends \Exception
{
    /**
     * @param string $address
     * @param int    $port
     */
    public function __construct($address, $port = null)
    {
        parent::__construct(sprintf("Fail connect to socket : %s:%s\n%s", $address, $port, socket_strerror(socket_last_error())));
    }
}
