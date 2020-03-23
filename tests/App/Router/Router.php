<?php declare(strict_types = 1);

namespace App\Router;

use Nette;

final class Router
{

	public static function createRouter(): Nette\Application\IRouter
	{
		$route = new Nette\Application\Routers\RouteList();
		$route[] = new Nette\Application\Routers\Route('<presenter>/<action>[/<id>]', 'Base:default');
		return $route;
	}

}
