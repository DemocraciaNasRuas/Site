
<?php

require 'vendor/autoload.php';

session_start();

function object_to_array($array) {
    return json_decode($array, true);
}

function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
    
    if(version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    }
    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    }
    else {
        $json = json_decode($json, $assoc);
    }

    return $json;
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

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

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
    $messages = $this->flash->getMessages();

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas();

    $protests = $DemocraciaNasRuas->get()[0];

    $protests = object_to_array($protests);

    return $this->view->render($response, 'home.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Site feito especialmente para o cadastro de protestos, palestras, debates, eventos sociais e muito mais sobre politica. Doações, noticias e artigos.',
        'messages' => $messages,
        'protests' => $protests
    ]);
})->setName('home');

$app->get('/{urlevent}/{id}', function ($request, $response, $args) {
    $messages = $this->flash->getMessages();

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas();

    $protest = $DemocraciaNasRuas->getById($id)[0];

    $protest = object_to_array($protest);

    return $this->view->render($response, 'event.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Evento feito por um movimento colaborador ou pessoa anonima.',
        'messages' => $messages,
        'protest' => $protest[0]
    ]);
})->setName('evento');

$app->get('/contato', function ($request, $response, $args) {
    $messages = $this->flash->getMessages();
    
    return $this->view->render($response, 'contato.html', [
        'title' => 'Democracia nas Ruas - Contato - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Entre em contato com os mantenedores do projeto, envie sugestões, criticas, elogios.',
        'messages' => $messages
    ]);
})->setName('contato');

$app->get('/procurar', function ($request, $response, $args) {

    $filters = $_GET;

    if (empty($filters['state'])) unset($filters['state']);

    if (empty($filters['city'])) unset($filters['city']);

    if (empty($filters['keywords'])) unset($filters['keywords']);

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas();

    $results = $DemocraciaNasRuas->getByFilters($filters);

    $results = object_to_array($results);
    echo '<pre>';print_r($results);exit;
    if (!isset($results[0]['protests'])) 
    {
        $this->flash->addMessage('sucess', 'Nenhum protesto encontrado com estes termos, tente novamente!');

        return $response->withStatus(302)->withHeader('Location', '/');
    }

});

$app->post('/register_event', function ($request, $response, $args) {
    
    $body = $request->getParsedBody()['register'];

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas($body, $_FILES);

    $responseRegister = $DemocraciaNasRuas->post();

    if ($responseRegister[0] == "Protesto criado com sucesso!")
    {
        $this->flash->addMessage('sucess', 'Protesto criado com sucesso!');

        return $response->withStatus(302)->withHeader('Location', '/');
    }

    $this->flash->addMessage('error', 'Ocorreu algum erro ao criar o protesto!');

    return $response->withStatus(302)->withHeader('Location', '/');

})->setName('register_event');

$app->run();