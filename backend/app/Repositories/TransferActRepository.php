<?php

namespace App\Repositories;

use App\Models\TransferAct;

class TransferActRepository
{
    public function getAll()
    {
        return TransferAct::all();
    }
    public function get($id){
        return TransferAct::find($id);
    }
}
