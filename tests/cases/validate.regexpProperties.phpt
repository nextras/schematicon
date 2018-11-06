<?php

namespace SchematiconTests;

use Nette\Neon\Neon;
use Schematicon\Validator\Validator;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$config = Neon::decode(<<<NEON
test:
    type: map
    regexpProperties:
        '^[a-z]$':
            type: string
NEON
);

$validator = new Validator(prepareSchema($config['test']));

Assert::same(
	[],
	$validator->validate(['f' => 'b'])->getErrors()
);

Assert::same(
	["Key 'foo' doesn't match expression '^[a-z]$'"],
	$validator->validate(['foo' => 'bar'])->getErrors()
);
