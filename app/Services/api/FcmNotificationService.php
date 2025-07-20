<?php

namespace App\Services\api;



 use App\Repositories\INotificationRepositories;
 use App\Traits\ResponseTrait;
use App\Models\User;
use Google\Client as Google_Client;
use Exception;
 use RuntimeException;

class FcmNotificationService
{

    use ResponseTrait ;
    protected $credentialsFilePath ,  $notificationRepository ;


    public function __construct(INotificationRepositories $notificationRepository )
    {
        $this->notificationRepository = $notificationRepository;
        $this->credentialsFilePath = storage_path('app/private/medical-consulting-app-firebase-adminsdk-x0zt9-cfa7b5a5af.json') ;


    }

    public function sendNotification( $title, $body, $userId)
    {
        $user = User::find($userId);

        $fcmToken = $user->fcm_token;

        if (!$fcmToken) {
            throw new Exception('ERROR_FCM_TOKEN');
        }

        $client = new Google_Client();

        $client->setAuthConfig($this->credentialsFilePath);
        $client->setScopes(['https://www.googleapis.com/auth/cloud-platform']);
//        $client->useApplicationDefaultCredentials();
        $client->setAccessType("offline");
        $token = $client->fetchAccessTokenWithAssertion();
        $accessToken = $token['access_token'];
        $headers = [
            "Authorization: Bearer $accessToken",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],

                "data" => [
                    "title" => $title ,
                    "body" => $body,

                ],
            ]
        ];

        dd(config('services.fcm.project_id'));



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/" . config('services.fcm.project_id') . "/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);


        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new RuntimeException('CURL_ERROR: ' . $err);
        }
           $this->notificationRepository->create(
              [
                  'user_id' => $userId,
                  'title' => $title,
                  'body' => $body,
               ]);


        return $response;
    }


}
