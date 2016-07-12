<?php

require 'vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views', [
        'debug' => true,
        // 'cache' => 'views/cache'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());
    return $view;
};

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Site feito especialmente para o cadastro de protestos, palestras, debates, eventos sociais e muito mais sobre politica. Doações, noticias e artigos.'
    ]);
})->setName('home');

$app->get('/{urlevent}', function ($request, $response, $args) {
    return $this->view->render($response, 'event.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Evento feito por um movimento colaborador ou pessoa anonima.'
    ]);
})->setName('evento');

$app->run();