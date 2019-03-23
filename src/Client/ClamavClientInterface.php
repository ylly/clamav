<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavScan\Client;

/**
 * Interface ClamavClientInterface.
 *
 * @see see: https://linux.die.net/man/8/clamd
 */
interface ClamavClientInterface
{
    public function ping();

    public function version();

    public function scan($path);

    public function contscan($path);

    public function multiscan($path);

    public function instream();

    public function fildes();

    public function stats();

    public function versioncommands();
}
