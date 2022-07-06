<?php
namespace Test\Fincana\PayeerAPI\Tests;

use Test\Fincana\PayeerAPI\PayeerRequestData;
use PHPUnit\Framework\TestCase;

class PayeerRequestDataTest extends TestCase
{
    protected string $api_id = '2ff85e3a-784f-46cd-972d-a9049f248ea7';
    protected string $secret = 'dD3TxWrfBEtAeQkN';

    protected PayeerRequestData $request_data;

    protected function setUp(): void
    {
        $this->request_data = new PayeerRequestData($this->api_id, $this->secret);
    }

    public function testGetPair()
    {
        $test_pair1 = 'BTC_USD';
        $test_pair2 = ['BTC_RUB', 'BTC_EUR'];
        $test_pair3 = ['BTC_USD', 'BTC_EUR'];
        $test_pair4 = ['BTC_RUB', 'BTC_USD', 'BTC_EUR'];

        $this->request_data->setPair($test_pair1)
                            ->setPair($test_pair2)
                            ->setPair($test_pair3)
                            ->setPair($test_pair4);

        $this->assertEquals(count($this->request_data->getPair()), 3);
    }
}