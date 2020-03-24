<?php declare(strict_types = 1);

namespace Tests;

use Tester;

require_once __DIR__ . '/../bootstrap.php';

final class DummyTest4 extends Tester\TestCase
{

	public function test01(): void
	{
		Tester\Assert::true(true);
	}

}

(new DummyTest4())->run();
