<?php

return [
    'image' => [
        'required' => 'The image field is required.',
        'file' => 'The image must be a file.',
        'mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
        'max' => 'The image may not be greater than 2048 kilobytes.',
    ],
    'name_game' => [
        'required' => 'The game name field is required.',
        'max' => 'The name must be less than 255 characters'
    ],
    'type_game' => [
        'required' =>'The type game field is required.' ,
        'in' => 'The nature of the challenge must be determined, whether individual enter (I) or enter (T) team.',
    ],
    'unique' => 'unique ',

    'name' => [
        'required' => 'Name field is required.',
        'string' => 'Name field must be text.',
        'max' => 'Users cannot exceed 4.',

    ],
    'members' => [
        'required' => 'Name field is required.',
        'string' => 'Phone number must be text.',
        'max' => 'Users cannot exceed 4.',
        'min' => 'Users cannot exceed 2.',

    ],
         'exists' => 'The location-pharmacy you attached do not exist.',


    'categories_id' => [
        'required' => 'The game type field is required',
        'integer' => 'The game type reference must be a number',
        'not_in' => 'The attached game type is invalid',
        'exists' => 'The game type does not exist' ,
        'array' => 'The reference game type must be a list',
        'min' => 'You must select at least 8 location-pharmacy',
        ],
    'blocked_Admin' => 'Your account has been blocked by the administrator',
    "INVALID_TOKEN"=>'Invalid token or user.' ,
    'TOKEN_EXPIRED'=> 'The code has expired. Try again later.'  ,
    'TOKEN_VALID' => 'Token valid' ,

    'TOO_MANY_ATTEMPTS'=>'Too many attempts' ,
    'Successfully updated changes.'=>'Successfully updated changes.' ,

    'user1_id' => [
        'required' => 'The value of the game origin does not exist',
        'integer' => 'The reference of the origin field must be a number',
        'exists' => 'The value returned from the origin field does not exist'
    ],
    'user2_id' => [
        'required' => 'The competitor field is required',
        'integer' => 'The competitor field reference must be a number',
        'exists' => 'The value returned from the competitor field does not exist'
    ],

    'challenge_id' => [
        'required' => 'The challenge ID is required.',
        'integer' => 'The challenge ID must be an integer.',
        'exists' => 'The selected challenge ID is invalid.',
    ],

    'first_competitor_id' => [
        'required' => 'The first competitor ID is required.',
        'integer' => 'The first competitor ID must be an integer.',
        'exists' => 'The selected first competitor ID is invalid.',
    ],

    'second_competitor_id' => [
        'required' => 'The second competitor ID is required.',
        'integer' => 'The second competitor ID must be an integer.',
        'exists' => 'The selected second competitor ID is invalid.',
    ],

    'winner_id' => [
        'required' => 'The winner ID is required.',
        'integer' => 'The winner ID must be an integer.',
        'exists' => 'The selected winner ID is invalid.',
    ],

    'score_FC' => [
        'required' => 'The score for competitor first is required.',
        'integer' => 'The score for competitor first must be an integer.',
        'max' => 'The score for competitor first must not exceed :max.',
    ],

    'score_SC' => [
        'required' => 'The score for competitor second is required.',
        'integer' => 'The score for competitor second must be an integer.',
        'max' => 'The score for competitor second must not exceed :max.',
    ],

    'name.required' => 'The name field is required.',
    'name.string' => 'The name must be a string.',
    'name.max' => 'The name may not be greater than 255 characters.',
    'competition_over_competitor_notification_title' => 'The competition is almost over!' ,
    'competition_over_competitor_notification_body' => 'Your friend has finished the game and only a little time is left.' ,
    'invitation_accept_competitor_notification_title'=> 'The challenge has begun !' ,
    'invitation_accept_competitor_notification_body' => 'Accept to join the Lets Go Challenge!',
    'invitation_notification_title' => 'New competition!' ,
    'invitation_notification_body' => 'Ahmed invited you to a competition in the Jawabna Lets go!' ,
    'accept_friend_request_notification_title' => 'Friend request accepted!' ,
    'accept_friend_request_notification_body' => 'accepted your friend request. Say hello and start a game together!' ,
    'full_name.required' => 'The full name field is required.',
    'full_name.string' => 'The full name must be a string.',
    'full_name.max' => 'The full name may not be greater than 255 characters.',
    'id.exists' => 'The specified class is not a valid base class.',
    'id.required' => 'The id field is required.',
    'id.integer' => 'The id must be a number.',
    'sender_id.required' => 'The name field is required.',
    'sender_id.exists' => 'The specified class is not a valid base class.',
    'receiver_id.required' => 'The name field is required.',
    'receiver_id.exists' => 'The specified class is not a valid base class.',
    'invalid_credentials' => 'Invalid password or email' ,
    'ERROR_OCCURRED' => 'ERROR OCCURRED' ,
    'id_not_found' => 'An error occurred: Item not found',
    'friend_request_exists' => 'You have already sent a friend request!',
    'friend_request_notification_title' => 'Request friendship' ,
    'friend_request_notification_body' => 'send you a friend request' ,
    'title.required' => 'The name field is required.',
    'title.string' => 'Name must be text.',
    'title.max' => 'The length of the name cannot exceed 255 characters.',

    'description.required' => 'The name field is required.',
    'description.string' => 'Name must be text.',
    'email.required' => 'The email field is required.',
    'email.string' => 'The email must be a string.',
    'email.email' => 'The email must be a valid email address.',
    'email.max' => 'The email may not be greater than 255 characters.',
    'email.unique' => 'The email has already been taken.',

    'phone.required' => 'The phone number field is required.',
    'phone.string' => 'The phone number must be a string.',
    'phone.unique' => 'The phone number has already been taken.',
    'phone.prefix' => 'The mobile number must contain the country prefix and consist of 9 to 14 digits.',
    'password' => [
        'required' => 'The password field is required.',
        'string' => 'The password must be a string.',
        'min' => 'The password must be at least :min characters.',
        'confirmed' => 'The password confirmation does not match.',
        'letters' => 'The password must contain at least one letter.',
        'mixed_case' => 'The password must contain both uppercase and lowercase letters.',
        'numbers' => 'The password must contain at least one number.',
        'symbols' => 'The password must contain at least one symbol.',
        'uncompromised' => 'The given password has appeared in a data breach. Please choose a different password.',
    ],

    'email' => [
        'required' => 'Email is required.',
        'email' => 'Email must be a valid email address.',
    ],

    'token' => [
        'required' => 'Token is required.',
        'digits' => 'Token must be a 4 digits',
    ],
    'country' => [
        'required' => 'Country is required.',

    ] ,
    'phone' => [
        'required' => 'Phone number is required.',
        'mobile_number' => 'Phone number is need prefix'
    ],
    'verification_method' => [
        'required' => 'Verification method is required.',
        'in' => 'The verification method must be either email or phone.',
    ],
    'name_ar' => [
        'required' => 'The game name in Arabic is required.',
        'string' => 'The game name in Arabic must be text.',
        'unique' => 'The game name in Arabic already exists.',
        'max' => 'The game name in Arabic must not exceed 255 characters.',
    ],

    'name_en' => [
        'required' => 'The game name in Arabic is required.',
        'string' => 'The game name in Arabic must be text.',
        'unique' => 'The game name in Arabic already exists.',
        'max' => 'The game name in Arabic must not exceed 255 characters.',
    ],

    'description_ar' => [
        'required' => 'The description in Arabic is required.',
        'string' => 'The description in Arabic must be text.',
        'max' => 'The description in Arabic must not exceed 255 characters.',
    ],
    'description_en' => [
        'required' => 'The description in Arabic is required.',
        'string' => 'The description in Arabic must be text.',
        'max' => 'The description in Arabic must not exceed 255 characters.',
    ],

    'rating' => [
        'required' => 'Rating is required.',
        'numeric' => 'Rating must be a number.',
        'min' => 'Rating must be greater than or equal to 0.',
        'max' => 'Rating must be less than or equal to 5.',
    ],



    'parent_id' => [
        'integer' => 'Parent ID must be an integer.',
        'min' => 'Parent ID must be greater than or equal to 0.',
        'exists' => 'Parent ID does not exist.',
    ],

    'famous_gaming' => [
        'boolean' => 'Property must be a boolean (true/false).',
    ],


];
