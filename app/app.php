<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container): App {
  $app = AppFactory::createFromContainer($container);
  (require __DIR__ . '/routes.php')($app);
  (require __DIR__ . '/middleware.php')($app);
  return $app;
};
