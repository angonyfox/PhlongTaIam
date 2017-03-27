<?
$app->get('/', 'DefaultController:indexAction');
$app->get('/hello/{name}', 'DefaultController:helloAction');
// $app->get('/throw', 'DefaultController:throwException');

$app->group('/api', function() {
    $this->get('/breaktowords/{text}', 'ApiController:breakIntoWordsAction');
});
