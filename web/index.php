<?php

require_once __DIR__.'/../vendor/autoload.php';
require '../vendor/themattharris/tmhoauth/tmhOAuth.php';
require '../vendor/themattharris/tmhoauth/tmhUtilities.php';
require '../app/Order.php';

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Symfony\Component\Yaml\Parser;


$app = new Application();

$app['debug'] = true;

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->post('/endpoint', function (Application $app, Request $request) {
  $data = $request->request->all();
  $order = new Order($data);
  return $app->json(postOrderToTwitter($order));
});

$app->run();

function postOrderToTwitter(Order $order)
{
    $ymlParser = new Parser();
    $credentials = $ymlParser->parse(file_get_contents('../twitter_credentials.yml'));
    $tmhOAuth = new tmhOAuth($credentials);

    $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
      'status' => "Just sold {$order->getAmount()} {$order->getCurrency()} worth of merchandise."
    ));

    if ($code == 200) {
      return json_decode($tmhOAuth->response['response']);
    } else {
      return json_decode($tmhOAuth->response['response']);
    }
}
