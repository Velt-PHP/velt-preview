<?php

require __DIR__ . '/../../vendor/autoload.php';

use PreviewEndpoints\Http\PreviewController;
use PreviewEndpoints\Http\PreviewErrorResponse;
use PreviewEndpoints\Http\Request;
use PreviewEndpoints\Renderer\ArrayJsonRenderer;
use PreviewEndpoints\VeltPageRepositoryFactory;
use PreviewSessionStore\PreviewSessionStore;

$request = Request::fromGlobals();
$store = new PreviewSessionStore(__DIR__ . '/../storage');

// Use VeltPageRepository to load .velt templates
$templatesPath = __DIR__ . '/../../templates';
$repository = VeltPageRepositoryFactory::create($templatesPath);

$controller = new PreviewController($store, $repository, new ArrayJsonRenderer());

if ($request->method !== 'GET') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(PreviewErrorResponse::methodNotAllowed()->toArray(), JSON_UNESCAPED_SLASHES);
    exit;
}

if (preg_match('#^/api/session/([^/]+)$#', $request->path, $matches)) {
    $response = $controller->session($matches[1]);
} elseif (preg_match('#^/api/preview/([^/]+)$#', $request->path, $matches)) {
    $response = $controller->preview($matches[1]);
} else {
    $response = new \PreviewEndpoints\Http\Response(404, json_encode(PreviewErrorResponse::notFound()->toArray(), JSON_UNESCAPED_SLASHES) ?: '{}', ['Content-Type' => 'application/json']);
}

http_response_code($response->statusCode);
foreach ($response->headers as $name => $value) {
    header($name . ': ' . $value);
}
echo $response->body;
