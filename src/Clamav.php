<?php

namespace YllyClamavScan;

use YllyClamavScan\Client\ClamavClientInterface;
use YllyClamavScan\Exception\FailedSocketConnectionException;
use YllyClamavScan\Exception\FailedSocketExtensionException;
use YllyClamavScan\Exception\FileNotFoundException;
use YllyClamavScan\Response\ScanResponse;

class Clamav
{
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
        } catch (FailedSocketConnectionException $connection) {
            return false;
        } catch (FailedSocketExtensionException $extension) {
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
     * @return ScanResponse
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
        } else {
            $scan = $this->client->multiscan($path);
        }

        return new ScanResponse($scan);
    }
}
