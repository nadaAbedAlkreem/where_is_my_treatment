<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Repositories\IAdminRepositories;
use App\Traits\ResponseTrait;


class AdminRepository  extends BaseRepository implements IAdminRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Admin();
    }
    public function getAllAdmins()
    {
        return $this->model::scopes('Admins');
    }
    public function getEmployee($idParentAdmin)
    {
        return $this->model::with('parent')->where('id', $idParentAdmin)->scopes('Employees');
    }
    public function getPharmacyOwners()
    {
        return $this->model::scopes('PharmacyOwners');
    }




}
