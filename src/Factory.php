<?php declare(strict_types = 1);

namespace AlesWita\FormRenderer;

use Nette;

class Factory
{

	/** @var Nette\Localization\ITranslator */
	protected $translator;

	/** @var string */
	protected $renderer;

	public function __construct(Nette\Localization\ITranslator $translator, string $renderer = BootstrapV4Renderer::class)
	{
		$this->translator = $translator;
		$this->renderer = $renderer;
	}

	public function getTranslator(): Nette\Localization\ITranslator
	{
		return $this->translator;
	}

	public function create(): Nette\Application\UI\Form
	{
		$form = new Nette\Application\UI\Form();

		$form->addProtection();
		$form->setTranslator($this->translator);
		$form->setRenderer(new $this->renderer());

		return $form;
	}

}
