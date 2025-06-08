<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Treatment;
use App\Models\TreatmentSearch;
use App\Repositories\IAdminRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Repositories\ITreatmentSearchRepositories;
use App\Traits\ResponseTrait;


class TreatmentSearchRepository  extends BaseRepository implements ITreatmentSearchRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new TreatmentSearch();
    }



}
