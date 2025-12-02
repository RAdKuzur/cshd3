<?php

namespace App\Repositories;

use App\Models\Auditorium;

class AuditoriumRepository
{
    public function getAll(){
        return Auditorium::all();
    }

    public function get($id){
        return Auditorium::where(['id' => $id])->first();
    }
}
