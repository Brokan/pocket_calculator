<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

/**
 * User logs module.
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property string $name_search
 * @property string $logs
 * @property string $created_at
 * @property string $updated_at
 */
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
