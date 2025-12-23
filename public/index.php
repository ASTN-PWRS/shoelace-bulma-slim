
<?php

use Slim\App;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

 // Start the session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$container = (new ContainerBuilder())
    ->addDefinitions(dirname(__DIR__, 1) . '/app/container.php')
    ->build();

$app = $container->get(App::class);

$app->setBasePath($settings['base_path']);
try { 
  $app->run();
} catch (Exception $e) {
  die( json_encode(array("status" => "failed", "message" => "This action is not allowed"))); 
}
