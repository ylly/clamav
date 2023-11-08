<?php

namespace YllyClamavScan\Client;

/**
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
