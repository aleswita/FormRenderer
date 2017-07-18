# Form Renderer
Form Renderer for [Nette Framework](https://nette.org) and [Bootstrap](http://getbootstrap.com/).

[![Build Status](https://travis-ci.org/aleswita/FormRenderer.svg?branch=master)](https://travis-ci.org/aleswita/FormRenderer)
[![Coverage Status](https://coveralls.io/repos/github/aleswita/FormRenderer/badge.svg?branch=master)](https://coveralls.io/github/aleswita/FormRenderer?branch=master)

## Installation
The best way to install AlesWita/FormRenderer is using [Composer](http://getcomposer.org/):
```sh
# For PHP 7.1, Nette Framework 2.4/3.0 and Bootstrap
$ composer require aleswita/formrenderer:dev-master
```


## Usage
You can use renderer as classic renderer in form factory:
```php
$form = new Nette\Application\UI\Form;
$form->setRenderer(new AlesWita\FormRenderer\BootstrapV4Renderer);
```
..or you can use prepared factory
```neon
services:
	- AlesWita\FormRenderer\Factory(@Nette\Localization\ITranslator)
	- App\Components\Forms\MyForm(@AlesWita\FormRenderer\Factory)
```
```php
final class MyForm extends Nette\Application\UI\Control
{
	/** @var AlesWita\FormRenderer\Factory */
	private $factory;


	/**
	 * @param AlesWita\FormRenderer\Factory
	 */
	public function __construct(AlesWita\FormRenderer\Factory $factory)
	{
		$this->factory = $factory;
	}


	/**
	 * @return Nette\Application\UI\Form
	 */
	public function create(): Nette\Application\UI\Form
	{
		$form = $this->factory->create();

		...

		return $form;
	}
}
```


## Features
**BootstrapV4Renderer** convert you forms to [Bootstrap V4](http://v4-alpha.getbootstrap.com/) design.

**Renderer support:**
- form errors
- groups
- groups description
- input errors
- input description
- **input addons** (left, right, both or multiple addons)
```php
$form->addText('text1', 'Label:')
	->addOption('left-addon', 'addon text');

$form->addText('text2', 'Label:')
	->addOption('right-addon', ['addon', 'text']);
```

**Link control** it's a form component, that can input link to your form as a button, look at the example:
```php
/**
 * @return Nette\Application\UI\Form
 */
public function create(): Nette\Application\UI\Form
{
	$form = $this->factory->create();

	...

	$form->addComponent(new AlesWita\FormRenderer\Controls\Link('Cancel'), 'cancel');

	$form['cancel']->getControlPrototype()
		->addClass('ajax')
		->setHref($this->link('cancel!'));

	return $form;
}
```
