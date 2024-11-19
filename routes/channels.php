<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel(
    'new-user',
    function () {
        return Auth::check();
    }
);

Broadcast::channel(
    'refresh-user',
    function () {
        return 'User refreshed';
    }
);

Broadcast::channel(
    'refresh-item',
    function () {
        return 'Item refreshed';
    }
);

Broadcast::channel(
    'refresh-customer',
    function () {
        return 'Customer refreshed';
    }
);
Broadcast::channel(
    'refresh-supplier',
    function () {
        return 'supplier refreshed';
    }
);
Broadcast::channel(
    'refresh-adjustment',
    function () {
        return 'Adjustment refreshed';
    }
);

Broadcast::channel(
    'refresh-purchase-order',
    function () {
        return 'Purchase order refreshed';
    }
);


Broadcast::channel(
    'refresh-delivery',
    function () {
        return 'Delivery refreshed';
    }
);

Broadcast::channel(
    'refresh-stock',
    function () {
        return 'Stock refreshed';
    }
);

Broadcast::channel(
    'refresh-backorder',
    function () {
        return 'Backorder refreshed';
    }
);

Broadcast::channel(
    'refresh-credit',
    function () {
        return 'Credit refreshed';
    }
);

Broadcast::channel(
    'refresh-transaction',
    function () {
        return 'Transaction refreshed';
    }
);

Broadcast::channel(
    'refresh-return',
    function () {
        return 'Return refreshed';
    }
);

Broadcast::channel(
    'refresh-inventory',
    function () {
        return 'Inventory refreshed';
    }
);
Broadcast::channel(
    'refresh-return',
    function () {
        return 'Return refreshed';
    }
);

Broadcast::channel(
    'refresh-void',
    function () {
        return 'Void refreshed';
    }
);

Broadcast::channel(
    'efresh-supplier-item',
    function () {
        return 'Supplier Item refreshed';
    }
);

