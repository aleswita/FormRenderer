<?php

/**
 * This file is part of the AlesWita\FormRenderer
 * Copyright (c) 2017 Ales Wita (aleswita+github@gmail.com)
 */

declare(strict_types=1);

namespace AlesWita\FormRenderer;

use Nette;


/**
 * @author Ales Wita
 * @license MIT
 */
class Factory
{
	/** @var Nette\Localization\ITranslator */
	protected $translator;


	/**
	 * @param Nette\Localization\ITranslator
	 */
	public function __construct(Nette\Localization\ITranslator $translator)
	{
		$this->translator = $translator;
	}


	/**
	 * @return Nette\Localization\ITranslator
	 */
	public function getTranslator(): Nette\Localization\ITranslator
	{
		return $this->translator;
	}


	/**
	 * @return Nette\Application\UI\Form
	 */
	public function create(): Nette\Application\UI\Form
	{
		$form = new Nette\Application\UI\Form;

		$form->addProtection();
		$form->setTranslator($this->translator);
		$form->setRenderer(new BootstrapV4Renderer);

		return $form;
	}
}
