<?php declare(strict_types = 1);

namespace AlesWita\FormRenderer\Tests\App\Presenters;

use AlesWita;
use Nette;

final class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var AlesWita\FormRenderer\Factory @inject */
	public $factory;

	protected function createComponentForm1(): Nette\Application\UI\Form
	{
		$form = $this->factory->create();

		$form->addGroup('group1')
			->setOption('label', 'group1 label')
			->setOption('description', 'group1 description');

		$form->addError('error1');

		$form->addText('text1', 'text1')
			->setOption('left-addon', 'left-addon')
			->setOption('description', 'description1');

		$form->addText('text2', 'text2')
			->setOption('right-addon', 'right-addon')
			->setDisabled();

		$form->addSelect('select1', 'select1')
			->setItems(['0', '1']);

		$form->addRadioList('radio1', 'radio1')
			->setItems(['0', '1']);

		$form->addCheckbox('checkbox1', 'checkbox1');

		$form->addUpload('upload1', 'upload1');

		$form->addSubmit('submit1', 'submit1');

		/*$form->addComponent(new AlesWita\FormRenderer\Controls\Link('submit2'), 'submit2');

		$form['submit2']->setDisabled()
			->getControlPrototype()
			->setHref($this->link('this'));*/

		return $form;
	}

	protected function createComponentForm2(): Nette\Application\UI\Form
	{
		$form = $this->factory->create();

		$form->addText('text1', 'text1')
			->setOption('left-addon', ['left', 'addon']);

		$form->addText('text2', 'text2')
			->setOption('right-addon', ['right', 'addon']);

		$form->addUpload('upload1', 'upload1');

		$form['text1']->addError('text1 error');
		$form['text2']->addError('text2 error');
		$form['upload1']->addError('upload1 error');

		return $form;
	}

}
