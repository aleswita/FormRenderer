<?php

/**
 * This file is part of the AlesWita\FormRenderer
 * Copyright (c) 2017 Ales Wita (aleswita+github@gmail.com)
 *
 * @phpVersion 7.1.0
 */

declare(strict_types=1);

namespace AlesWita\FormRenderer\Tests\Tests;

use AlesWita;
use Nette;
use Tester;

require_once __DIR__ . "/../bootstrap.php";


/**
 * @author Ales Wita
 * @license MIT
 */
final class BaseTest extends Tester\TestCase
{
	/**
	 * @return void
	 */
	public function testOne(): void {
		$configurator = new Nette\Configurator();
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addConfig(__DIR__ . "/../app/config/config.neon");

		$container = $configurator->createContainer();
		$presenterFactory = $container->getByType("Nette\\Application\\IPresenterFactory");

		$presenter = $presenterFactory->createPresenter("Base");
		$presenter->autoCanonicalize = FALSE;
		$request = new Nette\Application\Request("Base", "GET", ["action" => "default"]);
		$response = $presenter->run($request);

		Tester\Assert::true($response instanceof Nette\Application\Responses\TextResponse);
		Tester\Assert::true($response->getSource() instanceof Nette\Application\UI\ITemplate);

		$source = (string) $response->getSource();
		$dom = Tester\DomQuery::fromHtml($source);


		// form tag
		$data = $dom->find("form");

		Tester\Assert::count(1, $data);
		Tester\Assert::same("/", (string) $data[0]["action"]);
		Tester\Assert::same("post", (string) $data[0]["method"]);
		Tester\Assert::same("frm-form", (string) $data[0]["id"]);


		// div tag's
		$data = $dom->find('div[class="form-group row"]');

		Tester\Assert::count(6, $data);


		/**
		 * text1 field test
		 */
		$text1Container = (array) $data[0];
		$text1LabelContainer = (array) $text1Container["div"][0];
		$text1InputContainer = (array) $text1Container["div"][1];

		// container
		Tester\Assert::count(2, $text1Container);
		Tester\Assert::count(1, $text1Container["@attributes"]);
		Tester\Assert::same("form-group row", $text1Container["@attributes"]["class"]);
		Tester\Assert::count(2, $text1Container["div"]);

		// label container
		Tester\Assert::count(2, $text1LabelContainer);
		Tester\Assert::count(1, $text1LabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $text1LabelContainer["@attributes"]["class"]);
		Tester\Assert::same("text1", $text1LabelContainer["label"]);

		// input container
		Tester\Assert::count(2, $text1InputContainer);
		Tester\Assert::count(1, $text1InputContainer["@attributes"]);
		Tester\Assert::same("col-6", $text1InputContainer["@attributes"]["class"]);

		$foo = (array) $text1InputContainer["div"];
		Tester\Assert::count(3, $foo);
		Tester\Assert::count(1, $foo["@attributes"]);
		Tester\Assert::same("input-group", $foo["@attributes"]["class"]);
		Tester\Assert::same("left-addon", $foo["span"]);

		$foo = (array) $foo["input"];
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("text", $foo["@attributes"]["type"]);
		Tester\Assert::same("text1", $foo["@attributes"]["name"]);
		Tester\Assert::same("frm-form-text1", $foo["@attributes"]["id"]);
		Tester\Assert::same("form-control", $foo["@attributes"]["class"]);


		/**
		 * text2 field test
		 */
		$text2Container = (array) $data[1];
		$text2LabelContainer = (array) $text2Container["div"][0];
		$text2InputContainer = (array) $text2Container["div"][1];

		// container
		Tester\Assert::count(2, $text2Container);
		Tester\Assert::count(1, $text2Container["@attributes"]);
		Tester\Assert::same("form-group row", $text2Container["@attributes"]["class"]);
		Tester\Assert::count(2, $text2Container["div"]);

		// label container
		Tester\Assert::count(2, $text2LabelContainer);
		Tester\Assert::count(1, $text2LabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $text2LabelContainer["@attributes"]["class"]);
		Tester\Assert::same("text2", $text2LabelContainer["label"]);

		// input container
		Tester\Assert::count(2, $text2InputContainer);
		Tester\Assert::count(1, $text2InputContainer["@attributes"]);
		Tester\Assert::same("col-6", $text2InputContainer["@attributes"]["class"]);

		$foo = (array) $text2InputContainer["div"];
		Tester\Assert::count(3, $foo);
		Tester\Assert::count(1, $foo["@attributes"]);
		Tester\Assert::same("input-group", $foo["@attributes"]["class"]);
		Tester\Assert::same("right-addon", $foo["span"]);

		$foo = (array) $foo["input"];
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("text", $foo["@attributes"]["type"]);
		Tester\Assert::same("text2", $foo["@attributes"]["name"]);
		Tester\Assert::same("frm-form-text2", $foo["@attributes"]["id"]);
		Tester\Assert::same("form-control", $foo["@attributes"]["class"]);


		/**
		 * select1 field test
		 */
		$select1Container = (array) $data[2];
		$select1LabelContainer = (array) $select1Container["div"][0];
		$select1InputContainer = (array) $select1Container["div"][1];

		// container
		Tester\Assert::count(2, $select1Container);
		Tester\Assert::count(1, $select1Container["@attributes"]);
		Tester\Assert::same("form-group row", $select1Container["@attributes"]["class"]);
		Tester\Assert::count(2, $select1Container["div"]);

		// label container
		Tester\Assert::count(2, $select1LabelContainer);
		Tester\Assert::count(1, $select1LabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $select1LabelContainer["@attributes"]["class"]);
		Tester\Assert::same("select1", $select1LabelContainer["label"]);

		// input container
		Tester\Assert::count(2, $select1InputContainer);
		Tester\Assert::same("col-6", $select1InputContainer["@attributes"]["class"]);

		$foo = (array) $select1InputContainer["select"];

		Tester\Assert::count(3, $foo["@attributes"]);
		Tester\Assert::same("select1", $foo["@attributes"]["name"]);
		Tester\Assert::same("frm-form-select1", $foo["@attributes"]["id"]);
		Tester\Assert::same("form-control", $foo["@attributes"]["class"]);

		Tester\Assert::count(2, $foo["option"]);
		Tester\Assert::same("0", $foo["option"][0]);
		Tester\Assert::same("1", $foo["option"][1]);


		/**
		 * radio1 field test
		 */
		$radio1Container = (array) $data[3];
		$radio1LabelContainer = (array) $radio1Container["div"][0];
		$radio1InputContainer = (array) $radio1Container["div"][1];

		// container
		Tester\Assert::count(2, $radio1Container);
		Tester\Assert::count(1, $radio1Container["@attributes"]);
		Tester\Assert::same("form-group row", $radio1Container["@attributes"]["class"]);
		Tester\Assert::count(2, $radio1Container["div"]);

		// label container
		Tester\Assert::count(2, $radio1LabelContainer);
		Tester\Assert::count(1, $radio1LabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $radio1LabelContainer["@attributes"]["class"]);
		Tester\Assert::same("radio1", $radio1LabelContainer["label"]);

		// input container
		Tester\Assert::count(2, $radio1InputContainer);
		Tester\Assert::count(1, $radio1InputContainer["@attributes"]);
		Tester\Assert::same("col-6", $radio1InputContainer["@attributes"]["class"]);

		$foo = (array) $radio1InputContainer["div"];
		Tester\Assert::count(1, $foo["@attributes"]);
		Tester\Assert::same("form-check", $foo["@attributes"]["class"]);
		Tester\Assert::count(2, $foo["label"]);

		$foo = (array) $foo["label"][0];
		Tester\Assert::count(2, $foo);
		Tester\Assert::count(1, $foo["@attributes"]);
		Tester\Assert::same("form-check-label", $foo["@attributes"]["class"]);

		$foo = (array) $foo["input"];
		Tester\Assert::count(1, $foo);
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("radio", $foo["@attributes"]["type"]);
		Tester\Assert::same("radio1", $foo["@attributes"]["name"]);
		Tester\Assert::same("form-check-input", $foo["@attributes"]["class"]);
		Tester\Assert::same("0", $foo["@attributes"]["value"]);

		$foo = (array) $radio1InputContainer["div"];
		$foo = (array) $foo["label"][1];
		Tester\Assert::count(2, $foo);
		Tester\Assert::count(1, $foo["@attributes"]);
		Tester\Assert::same("form-check-label", $foo["@attributes"]["class"]);

		$foo = (array) $foo["input"];
		Tester\Assert::count(1, $foo);
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("radio", $foo["@attributes"]["type"]);
		Tester\Assert::same("radio1", $foo["@attributes"]["name"]);
		Tester\Assert::same("form-check-input", $foo["@attributes"]["class"]);
		Tester\Assert::same("1", $foo["@attributes"]["value"]);


		/**
		 * checkbox1 field test
		 */
		$checkbox1Container = (array) $data[4];
		$checkbox1LabelContainer = (array) $checkbox1Container["div"][0];
		$checkbox1InputContainer = (array) $checkbox1Container["div"][1];

		// container
		Tester\Assert::count(2, $checkbox1Container);
		Tester\Assert::count(1, $checkbox1Container["@attributes"]);
		Tester\Assert::same("form-group row", $checkbox1Container["@attributes"]["class"]);
		Tester\Assert::count(2, $checkbox1Container["div"]);

		// label container
		Tester\Assert::count(1, $checkbox1LabelContainer);
		Tester\Assert::count(1, $checkbox1LabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $checkbox1LabelContainer["@attributes"]["class"]);

		// input container
		Tester\Assert::count(2, $checkbox1InputContainer);
		Tester\Assert::count(1, $checkbox1InputContainer["@attributes"]);
		Tester\Assert::same("col-6", $checkbox1InputContainer["@attributes"]["class"]);

		$foo = (array) $checkbox1InputContainer["label"];
		Tester\Assert::count(2, $foo["@attributes"]);
		Tester\Assert::same("form-check-label", $foo["@attributes"]["class"]);
		Tester\Assert::same("frm-form-checkbox1", $foo["@attributes"]["for"]);

		$foo = (array) $foo["input"];
		Tester\Assert::count(1, $foo);
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("checkbox", $foo["@attributes"]["type"]);
		Tester\Assert::same("checkbox1", $foo["@attributes"]["name"]);
		Tester\Assert::same("form-check-input", $foo["@attributes"]["class"]);
		Tester\Assert::same("frm-form-checkbox1", $foo["@attributes"]["id"]);


		/**
		 * submit1 & submit2  buttons test
		 */
		$buttonsContainer = (array) $data[5];
		$buttonsLabelContainer = (array) $buttonsContainer["div"][0];
		$buttonsInputContainer = (array) $buttonsContainer["div"][1];

		// container
		Tester\Assert::count(2, $buttonsContainer);
		Tester\Assert::count(1, $buttonsContainer["@attributes"]);
		Tester\Assert::same("form-group row", $buttonsContainer["@attributes"]["class"]);
		Tester\Assert::count(2, $buttonsContainer["div"]);

		// label container
		Tester\Assert::count(1, $buttonsLabelContainer);
		Tester\Assert::count(1, $buttonsLabelContainer["@attributes"]);
		Tester\Assert::same("col-3 text-right", $buttonsLabelContainer["@attributes"]["class"]);

		// input container
		Tester\Assert::count(3, $buttonsInputContainer);
		Tester\Assert::count(1, $buttonsInputContainer["@attributes"]);
		Tester\Assert::same("col-6", $buttonsInputContainer["@attributes"]["class"]);

		$foo = (array) $buttonsInputContainer["input"];
		Tester\Assert::count(4, $foo["@attributes"]);
		Tester\Assert::same("submit", $foo["@attributes"]["type"]);
		Tester\Assert::same("submit1", $foo["@attributes"]["name"]);
		Tester\Assert::same("btn btn-outline-primary", $foo["@attributes"]["class"]);
		Tester\Assert::same("submit1", $foo["@attributes"]["value"]);

		Tester\Assert::same("submit2", $buttonsInputContainer["a"]);
	}
}


$test = new BaseTest;
$test->run();
