<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Category;
use App\Models\MedicationAvalabilityRequest;
use App\Repositories\IAdminRepositories;
use App\Repositories\ICategoryRepositories;
use App\Repositories\IMedicationAvalabilityRequestRepositories;
use App\Traits\ResponseTrait;


class MedicationAvalabilityRequestRepository  extends BaseRepository implements IMedicationAvalabilityRequestRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new MedicationAvalabilityRequest();
    }




}
