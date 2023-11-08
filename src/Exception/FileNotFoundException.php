<?php

namespace YllyClamavScan\Exception;

final class FileNotFoundException extends \Exception
{
    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        parent::__construct(sprintf('File not found : %s', $filePath));
    }
}
