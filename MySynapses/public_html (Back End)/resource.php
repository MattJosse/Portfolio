<?php
// include CORS
require_once 'project101/headers/cors_header.php';

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}

// Si on arrive là, c'est que l'on est pas "mort" et que notre application et
// notre utilisateur sont bien authentifiés
echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));

