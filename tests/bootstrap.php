<?php

/**
 * This file is part of the AlesWita\Components\WebLoader
 * Copyright (c) 2017 Ales Wita (aleswita+github@gmail.com)
 */

declare(strict_types=1);

if (@!include __DIR__ . "/../vendor/autoload.php") {
	echo "Install Nette Tester using `composer install`";
	exit(1);
}

require_once __DIR__ . "/app/presenters/BasePresenter.php";
require_once __DIR__ . "/app/router/Router.php";
require_once __DIR__ . "/app/service/FakeTranslator.php";

Tester\Environment::setup();

define("TEMP_DIR", __DIR__ . "/tmp/" . lcg_value());
@mkdir(dirname(TEMP_DIR));
@mkdir(TEMP_DIR);
