<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{
    public function getAll(){
        return Notification::all();
    }
    public function get($id){
        return Notification::find($id);
    }
    public function getByUserId($userId)
    {
        return Notification::where('user_id', $userId)->get();
    }
    public function read($id)
    {
        return DB::table('notifications')->where('id', $id)->update([
            'is_read' => Notification::READ
        ]);
    }
    public function unread($id)
    {
        return DB::table('notifications')->where('id', $id)->update([
            'is_read' => Notification::UNREAD
        ]);
    }
    public function create($data){
        return DB::table('notifications')->insert($data);
    }

}
