
<?php

require 'vendor/autoload.php';

session_start();

function object_to_array($array) 
{
    return json_decode($array, true);
}

function getStates() 
{
    $ch = curl_init() or die (curl_error($ch));
    $getdata = http_build_query(
        array(
            'formato'       => 'json',
            'chave'         => '6V34V44F7'
        )
    );
    $options = array(
            CURLOPT_URL => "http://www.devmedia.com.br/api/estadoscidades/service/estados/?$getdata",
            CURLOPT_RETURNTRANSFER => 1
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch) or die ("<p>ERRO AO FAZER A REQUISIÇÃO </p>".curl_error($ch));
    curl_close($ch);
 
    return json_decode($result);
}

function getCidadesByUf($uf)
{
    $ch = curl_init() or die (curl_error($ch));
    $getdata = http_build_query(
        array(
            'formato'       => 'json',        
            'uf'            => $uf,
            'chave'         => '6V34V44F7'
        )
    );
    $options = array(
            CURLOPT_URL => "http://www.devmedia.com.br/api/estadoscidades/service/cidades/?$getdata",
            CURLOPT_RETURNTRANSFER => 1
    );
    
    curl_setopt_array($ch, $options);
    
    $result = curl_exec($ch) or die ("<p>ERRO AO FAZER A REQUISIÇÃO </p>".curl_error($ch));

    curl_close($ch);
 
    return json_decode($result);
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

    $protests = $DemocraciaNasRuas->get();

    return $this->view->render($response, 'home.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Site feito especialmente para o cadastro de protestos, palestras, debates, eventos sociais e muito mais sobre politica. Doações, noticias e artigos.',
        'messages' => $messages,
        'states' => getStates()->estados->uf,
        'protests' => $protests
    ]);
})->setName('home');

$app->get('/{urlevent}/{id}', function ($request, $response, $args) {
    $messages = $this->flash->getMessages();

    $DemocraciaNasRuas = new \App\Lib\DemocraciaNasRuas();

    $protest = $DemocraciaNasRuas->getById($id)[0];
    
    return $this->view->render($response, 'event.html', [
        'title' => 'Democracia nas Ruas - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Evento feito por um movimento colaborador ou pessoa anonima.',
        'messages' => $messages,
        'states' => getStates()->estados->uf,
        'protest' => $protest
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

    if (empty($results[0])) 
    {
        $this->flash->addMessage('sucess', 'Nenhum protesto encontrado com estes termos, tente novamente!');

        return $response->withStatus(302)->withHeader('Location', '/');
    }

    return $this->view->render($response, 'search.html', [
        'title' => 'Democracia nas Ruas - Busca - Protestos, palestras, debates e eventos sociais.',
        'description' => 'Busca por - ' . http_build_query($filters),
        'messages' => $messages,
        'states' => getStates()->estados->uf,
        'protests' => json_decode($results)
   ]);
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

$app->get('/states', function ($request, $response, $args) {

    $states = json_decode(getStates());
    
    header("Content-Type: application/json");
    
    echo json_encode($states->estados->uf);
    
    exit;
})->setName('states');

$app->run();