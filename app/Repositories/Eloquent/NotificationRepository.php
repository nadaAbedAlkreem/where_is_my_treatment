<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\INotificationRepositories;

class NotificationRepository extends BaseRepository implements INotificationRepositories
{
     public function __construct()
    {
        $this->model = new Notification();
    }

}

{



}
