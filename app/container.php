<?php declare(strict_types=1);

use Slim\App;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestHandlerInterface;
//
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
//Template Engine
use Latte\Engine;
use Latte\Loaders\FileLoader;
use Latte\Bridges\Tracy\TracyExtension;
use App\Renderer\TemplateRenderer;
//CSRF Guard
use Slim\Csrf\Guard;
//
use App\Renderer\MarkdownRenderer;
use App\Controller\MarkdownController;
use App\Extension\AdmonitionExtension;
use League\CommonMark\Extension\ExtensionInterface;
use function DI\autowire;
use function DI\get;

return [
  'settings' => fn () => require __DIR__ . '/settings.php',
  'logger' => function(ContainerInterface $container){
    $settings = $container->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $format = "[%datetime%] %level_name% %message% %context% %extra%\n";
    $handler = new RotatingFileHandler($settings['path'].'/'.$settings['name'].'.log', 365, Monolog\Logger::INFO);
    $handler->setFilenameFormat('{date}-{filename}', RotatingFileHandler::FILE_PER_DAY);
    $handler->setFormatter($formatter);    
    $logger->pushHandler($handler);
    return $logger;
  },
  // DI Container to App
  App::class => function (ContainerInterface $container) {
    $app = AppFactory::createFromContainer($container);
    $settings = $container->get('settings')['app'];
    // Register routes
    (require __DIR__ . '/routes.php')($app);
    // Register middleware
    (require __DIR__ . '/middleware.php')($app);
    $app->setBasePath($settings['base_path']);
    return $app;
  },
	Engine::class => function (ContainerInterface $container) {
		$latte = new Engine();
		$settings = $container->get('settings')['latte'];
		$latte->setLoader(new FileLoader($settings['template']));
		$latte->setTempDirectory($settings['template_temp']);
		$latte->setAutoRefresh($settings['auto_refresh']);
    $latte->addExtension(new TracyExtension);
		return $latte;
	},
  TemplateRenderer::class => function (ContainerInterface $container) {
    $engine = $container->get(Engine::class);
    $app = $container->get(App::class);
    $basepath = $app->getBasePath();
    return new TemplateRenderer($engine, $basepath);
  },
  // 拡張機能をまとめた配列を定義
  'markdown.extensions' => [
    get(AdmonitionExtension::class),
  ],
  // MarkdownRenderer に拡張を注入
  MarkdownRenderer::class => autowire()
    ->constructorParameter('extensions', get('markdown.extensions')),
  // MarkdownController に MarkdownRenderer を自動注入
  MarkdownController::class => autowire(),
  // 拡張クラスも自動解決
  AdmonitionExtension::class => autowire(),  
];

