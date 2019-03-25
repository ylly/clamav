# Clamav PHP library

[![Build Status](https://travis-ci.org/ylly/clamav.svg?branch=master)](https://travis-ci.org/ylly/clamav)

This library allows you to easily scan file with ClamAv into you project

## Require
* PHP 5.6+
* PHP Socket

## Installation

```
$ composer req ylly/php-clamav-scan
```

## Usage

Create Clamav object :
```php
$clamav = ClamavFactory::createFromYamlFile('/some/config/file.yaml');
```

### Clamav Available

You can check if clamav is available with PING command.
```php
$clamav->isAvailable();
```

### Clamav Version

Get version of clamav

```php
$clamav->getVersion();
```

Note : if clamav is unavailable, the function throw an `FailedSocketConnectionException`

### Clamav scan

```php
// scan path
$result = $clamav->scanPath($path);
```

`$result` is instance of ScanResponse

Status combine with binary or ( | ) : 
1. `Clamav::CLAMAV_INFECT`
2. `Clamav::CLAMAV_ERROR`
3. `Clamav::CLAMAV_CLEAN`

Use helper for check status
* `isInfected()`
* `isUnckeck()`
* `isClean()`
* `hasSomeProblems()`


Note : if clamav is unavailable, the function throw an `FailedSocketConnectionException`

## Configuration file

```yaml
address: '/var/run/clamav/clamd.sock' # Unix socket or IPv4 / IPv6
port: 3310 # optional for IP
socket_length: 200000 # optionnal
```

