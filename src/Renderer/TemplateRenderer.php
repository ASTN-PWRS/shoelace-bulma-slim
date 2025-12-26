<?php

namespace App\Renderer;

use Slim\App;
use Latte\Engine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

final class TemplateRenderer
{
	private array $assets = [];
	public function __construct(private Engine $engine,private $basepath)
  {
    $this->engine = $engine;
		$this->basepath = $basepath;
		// コンポーネント関数を登録 
		$this->engine->addFunction('renderComponent', function (string $name, array $params = [])
		{ 
			$componentPath = __DIR__ . "/../../templates/components/{$name}.latte";
			// JSファイルが存在すればアセットに追加 
			$jsPath = "{$name}.js";
			// 公開パスに合わせて調整 
			$this->addAsset('js', $jsPath);
			return $this->engine->renderToString($componentPath, $params); 
		});		
  }

	public function render(Response $response, string $template, array $data = [] ): Response
	{
		$data +=array('basepath'=>$this->basepath);
		$string = $this->engine->renderToString($template, $data);
		$response->getBody()->write($string);
		return $response;
	}
	// TemplateRenderer.php に追加

private function addAsset(string $type, string $path): void
{
	if (file_exists(__DIR__ . "/../../public/js/{$jsPath}"))
	{ 
		if (!isset($this->assets[$type])) {
    	$this->assets[$type] = [];
  	}
  	if (!in_array($path, $this->assets[$type], true)) {
    	$this->assets[$type][] = $path;
  	}
	}
}

public function getAssets(string $type): array
{
    return $this->assets[$type] ?? [];
}


}
