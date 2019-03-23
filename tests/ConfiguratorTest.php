<?php

/*
 * This file is part of Clamav library.
 * (c) Samuel Queniart <samuel@ylly.fr>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace YllyClamavTest;

use PHPUnit\Framework\TestCase;
use YllyClamavScan\Clamav;
use YllyClamavScan\Configurator;
use YllyClamavScan\Factory\ClamavFactory;

/**
 * @internal
 * @coversNothing
 */
final class ConfiguratorTest extends TestCase
{
    public function testConfigureFromArray()
    {
        $config = Configurator::loadFromFile(__DIR__.'/config.yml');
        $clamav = ClamavFactory::createFromArray($config);
        $this->assertTrue($clamav instanceof Clamav);
    }

    public function testConfigureFromArrayWithProxy()
    {
        $config = Configurator::loadFromFile(__DIR__.'/config.yml');
        $clamav = ClamavFactory::createFromArray($config);
        $this->assertTrue($clamav instanceof Clamav);
    }

    public function testConfigureFromFile()
    {
        $clamav = ClamavFactory::createFromYamlFile(__DIR__.'/config.yml');
        $this->assertTrue($clamav instanceof Clamav);
    }
}
