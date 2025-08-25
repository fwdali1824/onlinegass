<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\Message;

trait FirebaseNotificationTrait
{
    /**
     * Send a Firebase notification to a single device.
     *
     * @param string $fcmToken
     * @param string $title
     * @param string $body
     * @return bool
     */
    public function sendFirebaseNotification($fcmToken, $title, $body)
    {
        // Initialize Firebase
        $firebase = (new Factory)->withServiceAccount(storage_path('fcmJson.json')); // Ensure correct path
        $messaging = $firebase->createMessaging();

        // Create the notification
        $notification = Notification::create($title, $body);

        // Create the message with the FCM token
        $message = Message::new()
            ->withNotification($notification)
            ->withTarget($fcmToken);

        try {
            // Send the notification via Firebase
            $messaging->send($message);
            return true;
        } catch (\Exception $e) {
            // Log or handle error if necessary
            Log::error('Error sending Firebase notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a Firebase notification to multiple devices.
     *
     * @param array $fcmTokens
     * @param string $title
     * @param string $body
     * @return bool
     */
    public function sendFirebaseNotificationToMultipleDevices(array $fcmTokens, $title, $body)
    {
        // Initialize Firebase
        $firebase = (new Factory)->withServiceAccount(storage_path('fcmJson.json'));
        $messaging = $firebase->createMessaging();

        // Create the notification
        $notification = Notification::create($title, $body);

        // Create the message for multiple tokens
        $message = Message::new()
            ->withNotification($notification)
            ->withTargets($fcmTokens);

        try {
            // Send the notification to all devices
            $messaging->send($message);
            return true;
        } catch (\Exception $e) {
            // Log or handle error if necessary
            Log::error('Error sending Firebase notification to multiple devices: ' . $e->getMessage());
            return false;
        }
    }
}

