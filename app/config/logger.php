<?php

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container): Logger {
  $settings = $container->get('settings')['logger'];
  $logger = new Logger($settings['name']);

  $format = "[%datetime%] %level_name% %message% %context% %extra%\n";
  $formatter = new LineFormatter($format, null, true, true);

  $handler = new RotatingFileHandler(
    $settings['path'] . '/' . $settings['name'] . '.log',
    365,
    Logger::INFO
  );
  $handler->setFilenameFormat('{date}-{filename}', RotatingFileHandler::FILE_PER_DAY);
  $handler->setFormatter($formatter);

  $logger->pushHandler($handler);
  return $logger;
};
