<?php

namespace Instante\Tests\Doctrine\Users;

use DateTime;
use Instante\Doctrine\DateKey;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

$dateStr = '2004-02-12T15:19:21+00:00';

$d = DateKey::fromDateTime(new DateTime($dateStr));
Assert::same($dateStr, (string)$d);