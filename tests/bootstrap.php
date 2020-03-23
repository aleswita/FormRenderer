<?php declare(strict_types = 1);

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}

require_once __DIR__ . '/App/Presenters/BasePresenter.php';
require_once __DIR__ . '/App/Router/Router.php';
require_once __DIR__ . '/App/Service/FakeTranslator.php';

Tester\Environment::setup();

define('TEMP_DIR', __DIR__ . '/tmp/' . lcg_value());
@mkdir(dirname(TEMP_DIR));
@mkdir(TEMP_DIR);
