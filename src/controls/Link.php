<?php

/**
 * This file is part of the AlesWita\FormRenderer
 * Copyright (c) 2017 Ales Wita (aleswita+github@gmail.com)
 */

declare(strict_types=1);

namespace AlesWita\FormRenderer\Controls;

use Nette;


/**
 * @author Ales Wita
 * @license MIT
 */
class Link extends Nette\Forms\Controls\Button
{
	/**
	 * @param string|object
	 */
	public function __construct($caption = NULL)
	{
		parent::__construct($caption);
		$this->control = Nette\Utils\Html::el("a");
	}

	/**
	 * @return bool
	 */
	public function isFilled(): bool {
		return FALSE;
	}

	/**
	 * @param string|object
	 * @return void
	 */
	public function getLabel($caption = NULL): void {
	}

	/**
	 * @param string|object
	 * @return Nette\Utils\Html
	 */
	public function getControl($caption = NULL): Nette\Utils\Html {
		$this->setOption("rendered", TRUE);
		$el = clone $this->control;

		$el->setText($this->translate($caption === NULL ? $this->caption : $caption));

		if ($this->isDisabled()) {
			$el->addClass("disabled");
		}

		return $el;
	}
}
