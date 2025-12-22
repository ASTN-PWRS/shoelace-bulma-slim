<?php

namespace App\Renderer;

use Slim\App;
use Latte\Engine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

final class TemplateRenderer
{
	public function __construct(private Engine $engine,private $basepath)
  {
    $this->engine = $engine;
		$this->basepath = $basepath;
  }

	public function render(Response $response, string $template, array $data = [] ): Response
	{
		$data +=array('basepath'=>$this->basepath);
		$string = $this->engine->renderToString($template, $data);
		$response->getBody()->write($string);
		return $response;
	}
}
