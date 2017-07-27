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
		'form' => [
			'container' => null,
		],

		'error' => [
			'container' => 'div class="row mb-3"',
			'item' => 'div class="col-12 alert alert-danger"',
		],

		'group' => [
			'container' => null,
			'label' => 'p class="h3 modal-header"',
			'description' => 'p class="pl-3 lead"',
		],

		'controls' => [
			'container' => null,
		],

		'pair' => [
			'container' => 'div class="form-group row"',
			'.required' => null,
			'.optional' => null,
			'.odd' => null,
			'.error' => 'has-danger',
		],

		'control' => [
			'container' => 'div class="col-6"',
			'.odd' => null,

			'description' => 'small class="form-text text-muted"',
			'requiredsuffix' => null,
			'errorcontainer' => 'div class="form-control-feedback"',
			'erroritem' => null,

			'.required' => null,
			'.text' => null,
			'.password' => null,
			'.file' => null,
			'.email' => null,
			'.number' => null,
			'.submit' => null,
			'.image' => null,
			'.button' => null,
		],

		'label' => [
			'container' => 'div class="col-3 text-right"',
			'suffix' => null,
			'requiredsuffix' => '*',
		],

		'hidden' => [
			'container' => null,
		],
	];


	/**
	 * @param array
	 * @return string
	 */
	public function renderPairMulti(array $controls): string
	{
		foreach ($controls as $control) {
			if ($control instanceof Nette\Forms\Controls\Button) {
				if ($control->getControlPrototype()->getClass() === null || (is_array($control->getControlPrototype()->getClass()) && !Nette\Utils\Strings::contains(implode(' ', array_keys($control->getControlPrototype()->getClass())), 'btn btn-'))) {
					$control->getControlPrototype()->addClass((empty($primary) ? 'btn btn-outline-primary' : 'btn btn-outline-secondary'));
				}
				$primary = true;
			}
		}

		return parent::renderPairMulti($controls);
	}


	/**
	 * @param Nette\Forms\IControl
	 * @return Nette\Utils\Html
	 */
	public function renderLabel(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox) {
			$control->getLabelPrototype()->addClass('form-check-label');

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->getLabelPrototype()->addClass('form-check-label');

		} else {
			$control->getLabelPrototype()->addClass('col-form-label');
		}

		$parent = parent::renderLabel($control);
		return $parent;
	}


	/**
	 * @param Nette\Forms\IControl
	 * @return Nette\Utils\Html
	 */
	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox) {
			$control->getControlPrototype()->addClass('form-check-input');

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->getContainerPrototype()->setName('div')->addClass('form-check');
			$control->getItemLabelPrototype()->addClass('form-check-label');
			$control->getControlPrototype()->addClass('form-check-input');

		} elseif ($control instanceof Nette\Forms\Controls\UploadControl) {
			if ($control->hasErrors()) {
				$control->getControlPrototype()->addClass('form-control-danger');
			}

			$control->getControlPrototype()->addClass('form-control-file');

		} else {
			if ($control->hasErrors()) {
				$control->getControlPrototype()->addClass('form-control-danger');
			}

			$control->getControlPrototype()->addClass('form-control');
		}

		$parent = parent::renderControl($control);

		// addons
		if ($control instanceof Nette\Forms\Controls\TextInput) {
			$leftAddon = $control->getOption('left-addon');
			$rightAddon = $control->getOption('right-addon');

			if ($leftAddon !== null || $rightAddon !== null) {
				$children = $parent->getChildren();
				$parent->removeChildren();

				$container = Nette\Utils\Html::el('div')->setClass('input-group');

				if ($leftAddon !== null) {
					if (is_array($leftAddon)) {
						foreach ($leftAddon as $v) {
							$container->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-addon')->setText($v));
						}
					} else {
						$container->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-addon')->setText($leftAddon));
					}
				}

				foreach ($children as $child) {
					$foo = Nette\Utils\Strings::after($child, $control->getControlPart()->render());

					if ($foo !== false) {
						$container->insert(null, $control->getControlPart()->render());
						$description = $foo;
					} else {
						$container->insert(null, $child);
					}
				}

				if ($rightAddon !== null) {
					if (is_array($rightAddon)) {
						foreach ($rightAddon as $v) {
							$container->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-addon')->setText($v));
						}
					} else {
						$container->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-addon')->setText($rightAddon));
					}
				}

				$parent->insert(null, $container);

				if (!empty($description)) {
					$parent->insert(null, $description);
				}
			}
		}

		return $parent;
	}
}
