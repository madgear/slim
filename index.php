use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$app = AppFactory::create();

// Define a route that performs a redirect
$app->get('/redirect', function (Request $request, Response $response) {
    // Perform the redirect
    return $response->withRedirect('/destination');
});

// Define the destination route
$app->get('/destination', function (Request $request, Response $response) {
    // Handle the destination route
    return $response->getBody()->write('This is the destination page');
});

$app->run();
