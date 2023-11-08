<?php

namespace YllyClamavTest;

use PHPUnit\Framework\TestCase;
use YllyClamavScan\Clamav;
use YllyClamavScan\Configurator;
use YllyClamavScan\Factory\ClamavFactory;

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
