<?php

/**
 * This file is part of the AlesWita\FormRenderer
 * Copyright (c) 2017 Ales Wita (aleswita+github@gmail.com)
 */

declare(strict_types=1);

namespace AlesWita\FormRenderer\Tests\App\Presenters;

use AlesWita;
use Nette;


/**
 * @author Ales Wita
 * @license MIT
 */
final class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var AlesWita\FormRenderer\Factory @inject */
	public $factory;

	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentForm(): Nette\Application\UI\Form {
		$form = $this->factory->create();

		$form->addText("text1", "text1")
			->setOption("left-addon", "left-addon");

		$form->addText("text2", "text2")
			->setOption("right-addon", "right-addon");

		$form->addSelect("select1", "select1")
			->setItems(["0", "1"]);

		$form->addRadioList("radio1", "radio1")
			->setItems(["0", "1"]);

		$form->addCheckbox("checkbox1", "checkbox1");

		$form->addSubmit("submit1", "submit1");

		$form->addComponent(new AlesWita\FormRenderer\Controls\Link("submit2"), "submit2");

		$form["submit2"]->getControlPrototype()
			->setHref($this->link("this"));

		return $form;
	}
}
