<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repositories\INotificationRepositories;

class NotificationRepository extends BaseRepository implements INotificationRepositories
{
     public function __construct()
    {
        $this->model = new Notification();
    }

    public function getNotificationForCurrentUser($request)
    {
        $currentUserId = $request->user();
        if (!$currentUserId) {
            throw new \Exception('UNAUTHORISED', 401);
        }
        $notificationsForCurrentUser = Notification::with('user')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);


        return NotificationResource::collection($notificationsForCurrentUser);

    }



}


