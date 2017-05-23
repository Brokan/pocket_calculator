<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

class UsersLogs extends Model
{
    protected $table = "users_logs";
    
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'name_search', 'logs'
    ];
}
