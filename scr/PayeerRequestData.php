<?php
namespace Test\Fincana\PayeerAPI;

use Test\Fincana\PayeerAPI\Options\Action;
use Test\Fincana\PayeerAPI\Options\Endpoints;
use Test\Fincana\PayeerAPI\Options\OrderType;

class PayeerRequestData
{
    protected ?string $apiId;
    protected ?string $apiSecret;
    protected string $base_url = 'https://payeer.com/api/trade/';
    protected ?string $full_url;
    protected ?Endpoints $endpoint;
    protected ?array $pair = [];
    protected OrderType $order_type;
    protected Action $action;
    protected int $amount;
    protected float $price;
    protected int $value;
    protected float $stop_price;

    /**
     * @param string $apiId
     * @param string $apiSecret
     */
    public function __construct(string $apiId, string $apiSecret)
    {
        $this->apiId = $apiId;
        $this->apiSecret = $apiSecret;
    }

    function getApiId() : string
    {
        return $this->apiId;
    }

    function getApiSecret() : string
    {
        return $this->apiSecret;
    }

    function setEndpoint(Endpoints $endpoint) : PayeerRequestData
    {
        $this->endpoint = $endpoint;
        $this->full_url = $this->base_url.$this->endpoint->value;

        return $this;
    }

    function getEndpoint() : ?Endpoints
    {
        return $this->endpoint ?? null;
    }

    function setOrderType(OrderType $order_type) : PayeerRequestData
    {
        $this->order_type = $order_type;

        return $this;
    }

    function getOrderType() : ?OrderType
    {
        return $this->order_type ?? null;
    }

    function setAction(Action $action): void
    {
        $this->action = $action;
    }

    function getAction() : ?Action
    {
        return $this->action ?? null;
    }

    function setPair(string|array $pair) : PayeerRequestData
    {
        $pair = (array)$pair;

        $this->pair = array_unique([...$this->pair, ...$pair]);

        return $this;
    }

    function getPair() : ?array
    {
        return count($this->pair) > 0 ? $this->pair : null;
    }

    function setAmount(int $amount) : PayeerRequestData
    {
        $this->amount = $amount;

        return $this;
    }

    function getAmount() : ?int
    {
        return $this->amount ?? null;
    }

    function setPrice(float $price) : PayeerRequestData
    {
        $this->amount = $price;

        return $this;
    }

    function getPrice() : ?float
    {
        return $this->price ?? null;
    }

    function setValue(int $value) : PayeerRequestData
    {
        $this->value = $value;

        return $this;
    }

    function getValue() : ?int
    {
        return $this->value ?? null;
    }

    function setStopPrice(float $stop_price) : PayeerRequestData
    {
        $this->stop_price = $stop_price;

        return $this;
    }

    function getStopPrice() : ?float
    {
        return $this->stop_price ?? null;
    }

    function getBaseUrl() : string
    {
        return $this->base_url;
    }

    function getFullUrl() : string
    {
        return $this->full_url;
    }
}