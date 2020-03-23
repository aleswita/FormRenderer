<?php declare(strict_types=1);

namespace AlesWita\FormRenderer\Tests\App\Service;

use Nette;

final class FakeTranslator implements Nette\Localization\ITranslator
{

	public function translate($message, ...$parameters): string
	{
		return $message;
	}

}
