<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\UserNotificationService;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    protected $user_notification_service;

    public function __construct()
    {
        $this->user_notification_service = new UserNotificationService(auth('api')->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_pending_notifications = $this->user_notification_service->getPendingNotifications()->keyBy('id');

        return response()->json($user_pending_notifications);
    }

    public function markAsRead(UserNotification $user_notification){
        if(auth('api')->id() != $user_notification->user_id){
            return response()->json([
                'message' => 'mark_notification_as_read_access_denied'
            ], 403);
        }
        
        if($user_notification->hasBeenRead()){
            return response()->json([
                'message' => 'mark_notification_as_read_already_been_read',
                'id' => $user_notification->id
            ]);
        }

        $user_notification->markAsRead();

        return response()->json([
            'message' => 'mark_notification_as_read_successfull',
            'id' => $user_notification->id
        ]);
    }

    public function notifyUser(User $user, Request $request){

        $this->user_notification_service = new UserNotificationService($user);
        
        $validated_user_notification_data = $this->user_notification_service->validateNotifyRequest($request);
        
        if($validated_user_notification_data){

            $validated_user_notification_data['user_id'] = $user->id;

            $user_notification = $this->user_notification_service->notifyFromArray($validated_user_notification_data);

            return response()->json([
                'message' => 'user_notified_successfully',
                'id' => $user_notification->id
            ]);
        }

        return response()->json(['error_message' => 'user_notify_failed'], 500);

    }

    public function markAllAsRead(){
        $user_notifications_altered = $this->user_notification_service->markAllNotificationsAsRead();

        return response()->json([
            'message' => 'mark_all_notifications_as_read_successfull',
            'amount' => $user_notifications_altered
        ]);
    }    
}
