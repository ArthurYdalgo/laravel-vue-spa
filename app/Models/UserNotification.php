<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'icon',
        'title',
        'notification',
        'read_at'
    ];

    private function setReadAt($date_time){
        $this->read_at = now();
        $this->save();
        return $this->read_at;
    }

    public function markAsRead(){
        return $this->setReadAt(now());
    }

    public function hasBeenRead(){
        return !is_null($this->read_at);
    }
}
