<?php 

namespace App\Services;

use App\Events\UserNotifications\SendUserNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Event;

class UserNotificationService
{
    private $user;
    
    public function __construct(User $user = null)
    {
        $this->user = $user;        
    }

    private function notificationQueryBuilder(){
        return $this->user->userNotifications();
    }

    public function getPendingNotifications()
    {        
        return $this->user ? $this->notificationQueryBuilder()->whereNull('read_at')->get() : collect([]);
    }

    public function markAllNotificationsAsRead(){
        return $this->notificationQueryBuilder()->whereNull('read_at')->update(['read_at' => now()]);
    }

    public function validateNotifyRequest($request){
        try {
            $validated = $request->validate([
                'title' => 'required|max:250',
                'icon' => 'nullable|max:250',
                'notification' => 'required|max:1000',
            ]);

            return $validated;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function notifyFromArray($array, User $user = null){
        if(!$user && !$this->user){
            throw new Exception("No user available", 1);            
        }

        return $this->notify($array['title'], $array['notification'], $array['icon'], $user);
    }

    public function notify($title, $notification, $icon = null, User $user = null){
        if(!$user && !$this->user){
            throw new Exception("No user available", 1);            
        }

        $user_notification_data = [
            'user_id' => $user ? $user->id : $this->user->id,
            'title' => $title,
            'notification' => $notification,
            'icon'=> $icon
        ];

        $user_notification = UserNotification::create($user_notification_data);

        Event::dispatch(new SendUserNotification($user_notification));

        return $user_notification;
    }

    public function maskNotificationsAsRead(UserNotification $user_notification){
        return $user_notification->markAsRead();
    }

    public function getAllNotifications()
    {
        return $this->user ? $this->notificationQueryBuilder()->get() : collect([]);
    }

    public function getReadNotifications()
    {
        return $this->user ? $this->notificationQueryBuilder()->whereNotNull('read_at')->get() : collect([]);
    }
   
}