<?php
namespace Test\Fincana\PayeerAPI\Options;

enum OrderType : string
{
    case limit = 'limit';
    case market = 'market';
    case stop_limit = 'stop_limit';
}