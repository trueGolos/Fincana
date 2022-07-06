<?php
namespace Test\Fincana\PayeerAPI\Options;

enum Endpoints : string
{
    // Public API
    case time = 'time';
    case info = 'info';
    case ticker = 'ticker';
    case orders = 'orders';
    case trades = 'trades';

    // Private API
    case account = 'account';
    case order_create = 'order_create';
    case order_status = 'order_status';
    case order_cancel = 'order_cancel';
    case orders_cancel = 'orders_cancel';
    case my_orders = 'my_orders';
    case my_history = 'my_history';
    case my_trades = 'my_trades';
}