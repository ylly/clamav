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
 * @see : https://linux.die.net/man/8/clamd
 */
interface ClamavClientInterface
{
    /**
     * @return string
     */
    public function ping();

    /**
     * @return string
     */
    public function version();

    /**
     * @param string $path
     *
     * @return string
     */
    public function scan($path);

    /**
     * @param string $path
     *
     * @return string
     */
    public function contscan($path);

    /**
     * @param string $path
     *
     * @return string
     */
    public function multiscan($path);

    /**
     * @return string
     */
    public function instream();

    /**
     * @return string
     */
    public function fildes();

    /**
     * @return string
     */
    public function stats();

    /**
     * @return string
     */
    public function versioncommands();
}
