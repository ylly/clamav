<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
