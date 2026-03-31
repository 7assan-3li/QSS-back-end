<?php
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$routes = collect(app('router')->getRoutes())->map(function ($route) {
    if(!str_starts_with($route->uri(), 'api')) return null;
    return [
        'methods' => array_diff($route->methods(), ['HEAD']),
        'uri' => $route->uri(),
    ];
})->filter()->values();
file_put_contents('storage/routes.json', json_encode($routes, JSON_PRETTY_PRINT));
