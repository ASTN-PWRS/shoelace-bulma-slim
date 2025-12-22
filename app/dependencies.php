<?php

use Psr\Container\ContainerInterface;
use Slim\App;

return [
  'settings' => fn () => require __DIR__ . '/settings.php',
  'logger'   => require __DIR__ . '/logger.php',
  App::class => require __DIR__ . '/app.php',
];
