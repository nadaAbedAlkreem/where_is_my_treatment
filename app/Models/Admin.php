<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory , Notifiable , SoftDeletes , HasRoles;
    protected $guard_name = 'admin';
    protected $guarded = [''];
    protected $fillable = [
        'admin_id',
        'email',
        'phone',
        'parent_admin_id' ,
        'image' ,
        'status' ,
        'password',
        'status_approved_for_pharmacy',
        'created_at'
    ];
    protected $dates = ['deleted_at'];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($admin) {

            $admin->employees()->each(function ($employees) {
                $employees->delete();
            });
        });
    }
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            });
    }

    public function isBlocked()
    {
        return $this->status === 'blocked';
    }
    public function scopePharmacyOwners(Builder $query): Builder
    {
        return $query ->whereHas('roles', function ($q) {
            $q->where('name', 'pharmacy_owner');
        });
    }

    public function scopeEmployees(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        });
    }
    public function parent()
    {
        return $this->belongsTo(Admin::class, 'parent_admin_id');
    }
    public function employees()
    {
        return $this->hasMany(Admin::class, 'parent_admin_id');
    }
    public function pharmacies()
    {
        return $this->hasOne(Pharmacy::class, 'admin_id');
    }



}
