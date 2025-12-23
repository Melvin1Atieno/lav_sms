<?php

namespace App\Repositories;

use App\Models\Nationality;
use App\Models\County;
use App\Models\Area;

class LocationRepo
{
    public function getStates()
    {
        return County::all();
    }

    public function getAllStates()
    {
        return County::orderBy('name', 'asc')->get();
    }

    public function getAllNationals()
    {
        return Nationality::orderBy('name', 'asc')->get();
    }

    public function getLGAs($state_id)
    {
        return Area::where('state_id', $state_id)->orderBy('name', 'asc')->get();
    }

}