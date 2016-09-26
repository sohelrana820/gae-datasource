<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    $dataSource = new \GoogleDataStore\DataStore('AIzaSyCUE6TAVB90aQ26Gm4N0ZaD3j6mOUTsixI', 'ptech-developer-training', 'api_core');
    $result = $dataSource->setKind('access_info')
        ->sendRequest()
        ->getResult();
    var_dump($result->getEntityResults());
    return $this->renderer->render($response, 'index.phtml', $args);
});
