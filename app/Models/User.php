<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens , HasFactory, Notifiable ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image' ,
        'phone',
        'provider' ,
        'provider_id' ,
        'fcm_token' ,

    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function medicationAvailabilityRequests()
    {
        return $this->hasMany(MedicationAvalabilityRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }
    public static function updateDeviceToken(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        if (!empty($user)) {
            $user->update(['fcm_token' => $request->fcm_token]);
            $user->save();
            return ['message' => 'UPDATE_FCM_TOKEN_SUCCESSFULLY'];
        }

        if(empty($user));
        {
            return ['message' => 'User not found'];

        }

    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->favorites()->delete();
            $user->ratings()->delete();
            $user->medicationAvailabilityRequests()->delete();
            $user->notifications()->delete();
            if ($user->location) {
                $user->location->delete();
            }
        });
    }

}
