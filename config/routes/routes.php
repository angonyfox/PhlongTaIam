<?php
$app->get('/', 'DefaultController:indexAction');
$app->map(['GET', 'POST'], '/datadict', 'DefaultController:datadictAction');
$app->get('/hello/{name}', 'DefaultController:helloAction');
// $app->get('/throw', 'DefaultController:throwException');

$app->group('/api', function() {
    $this->get('/breaktowords/{text}', 'ApiController:breakIntoWordsAction');
    $this->get('/breaktowordsdownload', 'ApiController:downloadAction');
    $this->post('/breaktowordsfile', 'ApiController:breakIntoWordsFileAction');
});
