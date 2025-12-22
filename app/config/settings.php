<?php declare(strict_types=1);

$settings = [
  // Monolog settings
  'logger' => [
    'name' => 'debug',
    'path' => __DIR__ . '/../var/logs',
    'level' => \Monolog\Logger::DEBUG,
  ],
  'latte' => [
    'template' => __DIR__ . '/../templates',
    'template_temp' => __DIR__ . '/../var/cache',
    'auto_refresh' => true
  ],
  'session' => [
    'name' => 'app',
    'lifetime' => 7200,
    'path' => null,
    'domain' => null,
    'secure' => false,
    'httponly' => true,
    'cache_limiter' => 'nocache',
  ]
];

return $settings;
