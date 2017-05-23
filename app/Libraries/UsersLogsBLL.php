<?php
namespace App\Libraries;

use Auth;
use App\Models\Logs\UsersLogs;
use App\Libraries\SimpleFunctions;

/**
 * Class to work with users logs.
 * 
 * @author Eduard Brokan <Eduard.Brokan@gmail.com>
 * @version 1.0.0
 */
class UsersLogsBLL
{
    /**
     * Get authorised user ID.
     * @return int user ID
     */
    public static function getUserId(){
        if (!Auth::check()){
            return 0;
        }
        return Auth::user()->getKey();
    }
    
    /**
     * Save user log.
     * @param string $name
     * @param string $logs
     */
    public static function saveLogs(string $name, string $logs){
        $userId = self::getUserId();
        if (empty($userId)){
            return false;
        }
        $itemSaved = self::getByName($userId, $name);
        if (!empty($itemSaved->id)){
            //Update previosly saved.
            $itemSaved->name = $name;
            $itemSaved->name_search = SimpleFunctions::createSearchWord($name);
            $itemSaved->logs = $logs;
            $itemSaved->save();
            return $itemSaved;
        }
        //Create new.
        $item = UsersLogs::create([
            'user_id' => $userId, 
            'name' => $name, 
            'name_search' => SimpleFunctions::createSearchWord($name),
            'logs' => $logs,
        ]);
        return $item;
    }
    
    /**
     * Get logs by name.
     * @param int $userId
     * @param string $name
     * @return UsersLogs
     */
    public static function getByName(int $userId, string $name){
        $nameSearch = SimpleFunctions::createSearchWord($name);
        $item = UsersLogs::where('user_id', $userId)->where('name_search', $nameSearch)->first();
        return $item;
    }
    
    /**
     * Get logs by ID.
     * @param int $userId
     * @param int $id
     * @return UsersLogs
     */
    public static function getById(int $userId, int $id){
        $item = UsersLogs::find($id);
        if($item->user_id != $userId){
            return false;
        }
        return $item;
    }
    
    /**
     * Get list of user save logs.
     * @return array of UsersLogs
     */
    public static function getUserLogs(){
        $userId = self::getUserId();
        if (empty($userId)){
            return [];
        }
        return UsersLogs::where('user_id', $userId)->get();
    }
}
