<?php

namespace YllyClamavScan\Response;

class ScanResponse
{
    const CLAMAV_INFECT = 1;
    const CLAMAV_CLEAN = 2;
    const CLAMAV_UNCHECK = 4;

    /**
     * @var int
     */
    private $status = 0;

    /**
     * @var array
     */
    private $scan;

    /**
     * @var string
     */
    private $original;

    /**
     * @param string $scan
     */
    public function __construct($scan)
    {

        $this->original = $scan;
        $this->scan = [];

        if (preg_match_all('/.* FOUND/', $scan, $founds) > 0) {
            $this->status = self::CLAMAV_INFECT;
            $this->scan = array_merge($this->scan, $founds);
        }

        if (preg_match_all('/.* ERROR/', $scan, $errors) > 0) {
            $this->status = $this->status|self::CLAMAV_UNCHECK;
            $this->scan = array_merge($this->scan, $errors);
        }

        if ($this->status === 0) {
            $this->status = self::CLAMAV_CLEAN;
        }
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getScan()
    {
        return $this->scan;
    }

    /**
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return bool
     */
    public function isInfected()
    {
        return boolval($this->status & self::CLAMAV_INFECT);
    }

    /**
     * @return bool
     */
    public function isUnckeck()
    {
        return boolval($this->status & self::CLAMAV_UNCHECK);
    }

    /**
     * @return bool
     */
    public function isClean()
    {
        return boolval($this->status & self::CLAMAV_CLEAN);
    }

    /**
     * @return bool
     */
    public function hasSomeProblems()
    {
        return $this->isInfected() || $this->isUnckeck();
    }
}