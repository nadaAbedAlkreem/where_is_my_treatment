<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentSearch extends Model
{
    /** @use HasFactory<\Database\Factories\TreatmentSearchFactory> */
    use HasFactory ;
    protected $fillable = [
       'user_id',
       'treatment_id',
       'ip_address',
    ] ;

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

}
