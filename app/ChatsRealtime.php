<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatsRealtime extends Model
{
    protected $guarded = [];
    protected $table = 'chats_realtimes';
    protected $appends = ['images_path'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
    public function getImagesPathAttribute()
    {
        $files = json_decode($this->files);
        $files_div = [];
        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];

        foreach ($files as $file) {
            if (in_array($file->type, $allowedMimeTypes)) {
                array_push($files_div, '<img width="100px" height="70px" src="' . asset('uploads/chat_files/' . $file->name) . '">');
            } else {
                array_push($files_div, '<br><a href="' . asset('uploads/chat_files/' . $file->name) . '"><i class="fa fa-file" style="font-size:30px;color:red"></i>' . $file->viewname . '</a><br>');
            }
        }
        return $files_div;
        //return asset('uploads/user_images/'.$this->image);
    }
}
