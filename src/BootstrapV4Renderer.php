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
class BootstrapV4Renderer extends Nette\Forms\Rendering\DefaultFormRenderer
{
	/** @var array */
	public $wrappers = [
		"form" => [
			"container" => NULL,
		],

		"error" => [
			"container" => "div class='row mb-3'",
			"item" => "div class='col-12 alert alert-danger'",
		],

		"group" => [
			"container" => NULL,
			"label" => "p class='h3 modal-header'",
			"description" => "p class='lead'",
		],

		"controls" => [
			"container" => NULL,
		],

		"pair" => [
			"container" => "div class='form-group row'",
			".required" => NULL,
			".optional" => NULL,
			".odd" => NULL,
			".error" => "has-danger",
		],

		"control" => [
			"container" => "div class='col-6'",
			".odd" => NULL,

			"description" => "small class='form-text text-muted'",
			"requiredsuffix" => NULL,
			"errorcontainer" => "div class='form-control-feedback'",
			"erroritem" => NULL,

			".required" => NULL,
			".text" => NULL,
			".password" => NULL,
			".file" => NULL,
			".email" => NULL,
			".number" => NULL,
			".submit" => NULL,
			".image" => NULL,
			".button" => NULL,
		],

		"label" => [
			"container" => "div class='col-3 text-right'",
			"suffix" => NULL,
			"requiredsuffix" => "*",
		],

		"hidden" => [
			"container" => NULL,
		],
	];


	/**
	 * @param array
	 * @return string
	 */
	public function renderPairMulti(array $controls): string {
		foreach ($controls as $control) {
			if ($control instanceof Nette\Forms\Controls\Button) {
				if ($control->getControlPrototype()->getClass() === NULL || (is_array($control->getControlPrototype()->getClass()) && !Nette\Utils\Strings::contains(implode(" ", array_keys($control->getControlPrototype()->getClass())), "btn btn-"))) {
					$control->getControlPrototype()->addClass((empty($primary) ? "btn btn-outline-primary" : "btn btn-outline-secondary"));
				}
				$primary = TRUE;
			}
		}

		return parent::renderPairMulti($controls);
	}

	/**
	 * @param Nette\Forms\IControl
	 * @return Nette\Utils\Html
	 */
	public function renderLabel(Nette\Forms\IControl $control): Nette\Utils\Html {
		if ($control instanceof Nette\Forms\Controls\Checkbox) {
			$control->getLabelPrototype()->addClass("form-check-label");

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->getLabelPrototype()->addClass("form-check-label");

		} else {
			$control->getLabelPrototype()->addClass("col-form-label");
		}

		$parent = parent::renderLabel($control);
		return $parent;
	}

	/**
	 * @param Nette\Forms\IControl
	 * @return Nette\Utils\Html
	 */
	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html {
		if ($control instanceof Nette\Forms\Controls\Checkbox) {
			$control->getControlPrototype()->addClass("form-check-input");

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->getContainerPrototype()->setName("div")->addClass("form-check");
			$control->getItemLabelPrototype()->addClass("form-check-label");
			$control->getControlPrototype()->addClass("form-check-input");

		} elseif ($control instanceof Nette\Forms\Controls\UploadControl) {
			if ($control->hasErrors()) {
				$control->getControlPrototype()->addClass("form-control-danger");
			}

			$control->getControlPrototype()->addClass("form-control-file");

		} else {
			if ($control->hasErrors()) {
				$control->getControlPrototype()->addClass("form-control-danger");
			}

			$control->getControlPrototype()->addClass("form-control");
		}

		$parent = parent::renderControl($control);

		// addons
		if ($control instanceof Nette\Forms\Controls\TextInput) {
			$leftAddon = $control->getOption("left-addon");
			$rightAddon = $control->getOption("right-addon");

			if ($leftAddon !== NULL || $rightAddon !== NULL) {
				$children = $parent->getChildren();
				$parent->removeChildren();

				$container = Nette\Utils\Html::el("div")->setClass("input-group");

				if ($leftAddon !== NULL) {
					if (is_array($leftAddon)) {
						foreach ($leftAddon as $v) {
							$container->insert(NULL, Nette\Utils\Html::el("span")->setClass("input-group-addon")->setText($v));
						}
					} else {
						$container->insert(NULL, Nette\Utils\Html::el("span")->setClass("input-group-addon")->setText($leftAddon));
					}
				}

				foreach ($children as $child) {
					$description = Nette\Utils\Strings::after($child, $control->getControlPart()->render());

					if ($description !== FALSE) {
						$container->insert(NULL, $control->getControlPart()->render());
					} else {
						$container->insert(NULL, $child);
					}
				}

				if ($rightAddon !== NULL) {
					if (is_array($rightAddon)) {
						foreach ($rightAddon as $v) {
							$container->insert(NULL, Nette\Utils\Html::el("span")->setClass("input-group-addon")->setText($v));
						}
					} else {
						$container->insert(NULL, Nette\Utils\Html::el("span")->setClass("input-group-addon")->setText($rightAddon));
					}
				}

				$parent->insert(NULL, $container);

				if ($description !== FALSE) {
					$parent->insert(NULL, $description);

				}
			}
		}

		return $parent;
	}
}
