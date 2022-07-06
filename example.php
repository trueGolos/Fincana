<?php
require 'vendor/autoload.php';

use Test\Fincana\PayeerAPI\PayeerRequestData;
use Test\Fincana\PayeerAPI\PayeerRequest;

use Test\Fincana\PayeerAPI\Options\OrderType;
use Test\Fincana\PayeerAPI\Options\Action;
use Test\Fincana\PayeerAPI\Options\Endpoints;

$api_id = '2ff85e3a-784f-46cd-972d-a9049f248ea7';
$secret = 'dD3TxWrfBEtAeQkN';

$test_pair1 = 'BTC_USD';
$test_pair2 = ['BTC_RUB', 'BTC_EUR'];

$request_data = (new PayeerRequestData($api_id, $secret))
    ->setPair($test_pair1)
    ->setPair($test_pair2);

$resp = (new PayeerRequest())
                ->setRequestData($request_data)
                ->setSSLVerify(false)
                ->info();

echo '<pre>';
print_r($resp);
echo '</pre>';