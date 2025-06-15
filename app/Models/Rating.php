<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\RatingFactory> */
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'user_id',
        'pharmacy_id' ,
        'rating' ,
        'comment' ,
        'type' ,
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

}
