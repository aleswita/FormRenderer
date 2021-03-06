<?php declare(strict_types = 1);

namespace AlesWita\FormRenderer;

use Nette;

class BootstrapV4Renderer extends Nette\Forms\Rendering\DefaultFormRenderer
{

	/** @var mixed[] */
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
			'.error' => null,
		],

		'control' => [
			'container' => 'div class="col-lg-6 col-md-9 col-sm-12"',
			'.odd' => null,

			'description' => 'small class="form-text text-muted"',
			'requiredsuffix' => null,
			'errorcontainer' => 'div class="invalid-feedback"',
			'erroritem' => null,

			'.required' => null,
			'.error' => null,
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
			'container' => 'div class="col-md-3 text-md-right col-sm-12"',
			'suffix' => null,
			'requiredsuffix' => '*',
		],

		'hidden' => [
			'container' => null,
		],
	];

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilitySymbolRequired
	 */
	public function renderErrors(?Nette\Forms\IControl $control = null, bool $own = true): string
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\RadioList || $control instanceof Nette\Forms\Controls\UploadControl) {
			$temp = $this->wrappers['control']['errorcontainer'];
			$this->wrappers['control']['errorcontainer'] = $this->wrappers['control']['errorcontainer'] . ' style="display: block"';
		}

		$parent = parent::renderErrors($control, $own);

		if (isset($temp)) {
			$this->wrappers['control']['errorcontainer'] = $temp;
		}

		return $parent;
	}

	/**
	 * @param Nette\Forms\IControl[] $controls
	 */
	public function renderPairMulti(array $controls): string
	{
		$primary = false;

		foreach ($controls as $control) {
			if ($control instanceof Nette\Forms\Controls\Button) {
				if ($control->controlPrototype->class === null || (is_array($control->controlPrototype->class) && !Nette\Utils\Strings::contains(implode(' ', array_keys($control->controlPrototype->class)), 'btn btn-'))) {
					$control->controlPrototype->addClass(!$primary ? 'btn btn-outline-primary' : 'btn btn-outline-secondary');
				}

				$primary = true;
			}
		}

		return parent::renderPairMulti($controls);
	}

	public function renderLabel(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\CheckboxList) {
			$control->labelPrototype->addClass('form-check-label');

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->labelPrototype->addClass('form-check-label');

		} else {
			assert($control instanceof Nette\Forms\Controls\BaseControl);
			$control->labelPrototype->addClass('col-form-label');
		}

		return parent::renderLabel($control);
	}

	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\CheckboxList) {
			$control->controlPrototype->addClass('form-check-input');

			if ($control instanceof Nette\Forms\Controls\CheckboxList) {
				$control->separatorPrototype->setName('div')->addClass('form-check form-check-inline');
			}

		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->containerPrototype->setName('div')->addClass('form-check');
			$control->itemLabelPrototype->addClass('form-check-label');
			$control->controlPrototype->addClass('form-check-input');

		} elseif ($control instanceof Nette\Forms\Controls\UploadControl) {
			$control->controlPrototype->addClass('form-control-file');

		} else {
			assert($control instanceof Nette\Forms\Controls\BaseControl);

			if ($control->hasErrors()) {
				$control->controlPrototype->addClass('is-invalid');
			}

			$control->controlPrototype->addClass('form-control');
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
					if (!is_array($leftAddon)) {
						$leftAddon = [$leftAddon];
					}

					$div = Nette\Utils\Html::el('div')->setClass('input-group-prepend');

					foreach ($leftAddon as $v) {
						$div->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-text')->setText($v));
					}

					$container->insert(null, $div);
				}

				$description = null;

				foreach ($children as $child) {
					$controlPart = $control->getControlPart();

					if ($controlPart !== null) {
						$foo = Nette\Utils\Strings::after($child, $controlPart->render());

						if ($foo !== null) {
							$container->insert(null, $controlPart->render());
							$description = $foo;
							continue;
						}
					}

					$container->insert(null, $child);
				}

				if ($rightAddon !== null) {
					if (!is_array($rightAddon)) {
						$rightAddon = [$rightAddon];
					}

					$div = Nette\Utils\Html::el('div')->setClass('input-group-append');

					foreach ($rightAddon as $v) {
						$div->insert(null, Nette\Utils\Html::el('span')->setClass('input-group-text')->setText($v));
					}

					$container->insert(null, $div);
				}

				$parent->insert(null, $container);

				if ($description !== null) {
					$parent->insert(null, $description);
				}
			}
		}

		return $parent;
	}

}
