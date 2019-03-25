<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavScan;

use YllyClamavScan\Client\ClamavClientInterface;
use YllyClamavScan\Exception\FailedSocketConnectionException;
use YllyClamavScan\Exception\FileNotFoundException;

class Clamav
{
    const CLAMAV_INFECT = 0;
    const CLAMAV_CLEAN = 1;
    const CLAMAV_UNCHECK = 2;

    private $client;

    public function __construct(ClamavClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        try {
            $ping = $this->client->ping();
        } catch (FailedSocketConnectionException $e) {
            return false;
        }

        return 'PONG' === $ping ? true : false;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->client->version();
    }

    /**
     * @param string $path
     * @param bool   $block
     * @param bool   $multithread
     *
     * @throws FileNotFoundException
     *
     * @return array
     */
    public function scanPath($path, $block = true, $multithread = false)
    {
        if (false === $block && true === $multithread) {
            throw new \LogicException("Bad pair params, block can't be false if multithread is true");
        }

        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }

        if (true === $block && false === $multithread) {
            $scan = $this->client->scan($path);
        } elseif (false === $block && false === $multithread) {
            $scan = $this->client->contscan($path);
        } elseif (true === $block && true === $multithread) {
            $scan = $this->client->multiscan($path);
        }

        if (preg_match_all('/.* FOUND/', $scan, $founds) > 0) {
            return [
                'status' => self::CLAMAV_INFECT,
                'scan' => $founds,
                'original' => $scan,
            ];
        }

        if (preg_match_all('/.* ERROR/', $scan, $errors) > 0) {
            return [
                'status' => self::CLAMAV_UNCHECK,
                'scan' => $errors,
                'original' => $scan,
            ];
        }

        return  [
            'status' => self::CLAMAV_CLEAN,
            'scan' => [],
            'original' => $scan,
        ];
    }
}
