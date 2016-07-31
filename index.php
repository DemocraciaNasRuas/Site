
<?php

require 'vendor/autoload.php';

session_start();

function getMessages() {
    $messages = $_SESSION['messages'];
    
    if (isset($messages) && !empty($messages))
        return $messages;

    return [];
}

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
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
        'description' => 'Site feito especialmente para o cadastro de protestos, palestras, debates, eventos sociais e muito mais sobre politica. Doações, noticias e artigos.',
        'messages' => getMessages()
    ]);
})->setName('home');

$app->get('/contato', function ($request, $response, $args) {
    return $this->view->render($response, 'contato.html', [
        'title' => 'Democracia nas Ruas - Contato - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Entre em contato com os mantenedores do projeto, envie sugestões, criticas, elogios.',
        'messages' => getMessages()
    ]);
})->setName('contato');

$app->get('/{urlevent}', function ($request, $response, $args) {
    return $this->view->render($response, 'event.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Evento feito por um movimento colaborador ou pessoa anonima.',
        'messages' => getMessages()
    ]);
})->setName('evento');

$app->get('contato', function() {
    return $this->view->render($response, 'contato.html', [
        'title' => 'Democracia nas Ruas - Contato - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Entre em contato com os mantenedores do projeto, envie sugestões, criticas, elogios.',
        'messages' => getMessages()
    ]);
})->setName('contato');

$app->post('/register_event', function ($request, $response, $args) {
    
    $body = $request->getParsedBody()['register'];

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas($body);

    $responseRegister = $DemocraciaNasRuas->post();

    if ($responseRegister[0] == "Protesto criado com sucesso!")
    {
            $_SESSION['messages'][] = [
                'type' => 'error',
                'message' => $responseRegister[0]
            ];

        header('Location: /');
        exit();
    }

    $_SESSION['messages'][] = [
        'type' => 'error',
        'message' => $responseRegister[0]
    ];

    header('Location: /');
    exit();

})->setName('register_event');

$app->run();