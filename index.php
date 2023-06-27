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



use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Handle POST request to '/submit' route
$app->post('/submit', function (Request $request, Response $response) {
    // Access the submitted data
    $data = $request->getParsedBody();

    // Process the submitted data
    $name = $data['name'];
    $email = $data['email'];

    // Perform actions with the submitted data (e.g., save to a database)

    // Return a response
    return $response->getBody()->write("Submitted data: Name = $name, Email = $email");
});

$app->run();
