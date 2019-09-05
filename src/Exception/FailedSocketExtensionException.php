<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavScan\Exception;

final class FailedSocketExtensionException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Socket extension not load in PHP");
    }
}
