<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
