<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Order;
use App\Notifications\NewOrderNotification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new NewOrderNotification($order));
        }
    }
}
