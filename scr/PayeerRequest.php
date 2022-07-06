<?php
namespace Test\Fincana\PayeerAPI;

use Test\Fincana\PayeerAPI\Options\Action;
use Test\Fincana\PayeerAPI\Options\Endpoints;
use Test\Fincana\PayeerAPI\Options\OrderType;

class PayeerRequest
{
    private \CurlHandle $curl;
    private PayeerRequestData $request_data;

    private bool $ssl_verify;

    public function __construct()
    {
        $this->initCurl();
    }

    function time() : ?array
    {
        $this->request_data->setEndpoint(Endpoints::time);

        return $this->doRequestCurl();
    }

    function info() : ?array
    {
        $this->request_data->setEndpoint(Endpoints::info);

        if ($this->request_data->getPair())
        {
            $post = ['pair' => implode(',', $this->request_data->getPair())];

            $this->curlPostMode($post);
        }

        return $this->doRequestCurl();
    }

    function ticker() : ?array
    {
        $this->request_data->setEndpoint(Endpoints::ticker);

        if ($this->request_data->getPair())
        {
            $post = ['pair' => implode(',', $this->request_data->getPair())];

            $this->curlPostMode($post);
        }

        return $this->doRequestCurl();
    }

    function orders() : ?array
    {
        if (!$this->request_data->getPair())
        {
            return null;
        }

        $this->request_data->setEndpoint(Endpoints::orders);

        $post = ['pair' => implode(',', $this->request_data->getPair())];
        $this->curlPostMode($post);

        return $this->doRequestCurl();
    }

    function trades() : ?array
    {
        if (!$this->request_data->getPair())
        {
            return null;
        }

        $this->request_data->setEndpoint(Endpoints::trades);

        $post = ['pair' => implode(',', $this->request_data->getPair())];
        $this->curlPostMode($post);

        return $this->doRequestCurl();
    }

    function account() : ?array
    {
        $this->request_data->setEndpoint(Endpoints::account);

        $post = ['ts' => round(microtime(true) * 1000)];
        $this->curlPostMode($post, private: true);

        return $this->doRequestCurl();
    }

    private function initCurl() : void
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, false);

        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
    }

    private function curlPostMode(array $post_data, bool $private = false) : void
    {
        $headers = ["Content-Type: application/json"];

        if ($private)
        {
            $headers[] = 'API-ID: '.$this->request_data->getApiId();
            $headers[] = 'API-SIGN: '.$this->generateSign();
        }

        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }

    private function doRequestCurl() : ?array
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->request_data->getFullUrl());

        $response = curl_exec($this->curl);
        curl_close($this->curl);

        $arResponse = json_decode($response, true);

        if (isset($arResponse['success']) AND $arResponse['success'] === true)
        {
            return $arResponse;
        }

        return null;
    }

    private function generateSign(string $algo = 'sha256') : string
    {
        $msec = json_encode(['ts' => round(microtime(true) * 1000)]);

        $sign = hash_hmac($algo,
                     $this->request_data->getEndpoint()->value.$msec,
                          $this->request_data->getApiSecret() );

        return $sign;
    }

    function setSSLVerify(bool $ssl = true) : PayeerRequest
    {
        $this->ssl_verify = $ssl;

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $this->ssl_verify);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, $this->ssl_verify);

        return $this;
    }

    function getSSLVerify() : bool
    {
        return $this->ssl_verify;
    }

    function setRequestData(PayeerRequestData $request_data) : PayeerRequest
    {
        $this->request_data = $request_data;

        return $this;
    }
}