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
    if ($request->headers->get('Magento-Topic') === 'order/created') {
        $app->finish(function(Request $request){
            $data = $request->request->all();
            $order = new Order($data);
            postOrderToTwitter($order);
        });
    }
    return '';
});

$app->run();

function postOrderToTwitter(Order $order)
{
    $message = "({$order->getId()}) Just sold {$order->getAmount()} {$order->getCurrency()} worth of merchandise.";

    $ymlParser = new Parser();
    $credentials = $ymlParser->parse(file_get_contents('../twitter_credentials.yml'));
    $tmhOAuth = new tmhOAuth($credentials);

    $code = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
        'status' => $message
    ));

    $response = $tmhOAuth->response['response'];
    if ($code != 200) {
        error_log("Twitter says: {$code}");
    }
    return json_decode($response);
}
