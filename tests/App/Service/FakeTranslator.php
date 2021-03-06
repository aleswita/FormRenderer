<?php declare(strict_types = 1);

namespace App\Service;

use Nette;

final class FakeTranslator implements Nette\Localization\ITranslator
{

	/**
	 * @inheritDoc
	 */
	public function translate($message, ...$parameters): string
	{
		return $message;
	}

}
