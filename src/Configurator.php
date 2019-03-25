<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavScan;

use Symfony\Component\Yaml\Yaml;

class Configurator
{
    /**
     * @param string $pathToFile
     *
     * @return array
     */
    public static function loadFromFile($pathToFile)
    {
        $configFile = file_get_contents($pathToFile);

        return Yaml::parse($configFile);
    }
}
