<?php

namespace App\Services;

use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function createNotification(string $type, $notifiable, array $data): void
    {
        $notifiable->notify(new \App\Notifications\CustomNotification($type, $data));
    }

    public function markAsRead(DatabaseNotification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAllAsRead($user): void
    {
        $user->unreadNotifications->markAsRead();
    }

    public function getUnreadCount($user): int
    {
        return $user->unreadNotifications()->count();
    }
}
