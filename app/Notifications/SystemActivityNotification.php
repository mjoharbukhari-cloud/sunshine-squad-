<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemActivityNotification extends Notification
{
    use Queueable;

    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     * FIXED: Tells Laravel to store this telemetry inside the `notifications` database table.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * Maps perfectly to the keys your dashboard views are looking for.
     */
    public function toArray($notifiable)
    {
        return [
            'type'          => $this->details['type'] ?? 'system_alert',
            'product_name'  => $this->details['product_name'] ?? 'System Event',
            'customer_name' => $this->details['customer_name'] ?? 'System Process',
            'total_price'   => $this->details['total_price'] ?? 0,
        ];
    }
}