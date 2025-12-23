<?php

namespace App\Markdown\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Renderer\MarkdownRenderer;

class MarkdownController
{
    private MarkdownRenderer $renderer;

    public function __construct(MarkdownRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $markdown = $data['markdown'] ?? '';

        $html = $this->renderer->toHtml($markdown);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
