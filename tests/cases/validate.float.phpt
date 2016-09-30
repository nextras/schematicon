<?php

namespace NextrasTests\Schematicon;

use Nette\Neon\Neon;
use Nextras\Schematicon\Validator;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$config = Neon::decode(<<<NEON
basic:
	type: float
nullable:
	type: float|null
NEON
);


$validator = new Validator($config['basic']);

Assert::same(
	[],
	$validator->validate(1.0)->getErrors()
);

Assert::same(
	["Wrong data type in '/'; expected 'float'; got 'int'"],
	$validator->validate(1)->getErrors()
);

Assert::same(
	["Wrong data type in '/'; expected 'float'; got 'string'"],
	$validator->validate("string")->getErrors()
);

Assert::same(
	["Wrong data type in '/'; expected 'float'; got 'array'"],
	$validator->validate([])->getErrors()
);


// =====================================================================================================================


$validator = new Validator($config['nullable']);

Assert::same(
	[],
	$validator->validate(null)->getErrors()
);

Assert::same(
	["Wrong data type in '/'; expected 'float|null'; got 'array'"],
	$validator->validate([])->getErrors()
);