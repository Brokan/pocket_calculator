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
class UsersLogsBLL {

    /**
     * Get authorised user ID.
     * @return int user ID
     */
    public static function getUserId(): int {
        if (!Auth::check()) {
            return 0;
        }
        return Auth::user()->getKey();
    }

    /**
     * Save user log.
     * @param string $name
     * @param string $logs
     * @return UsersLogs
     */
    public static function saveLogs(string $name, string $logs): UsersLogs {
        $userId = self::getUserId();
        if (empty($userId)) {
            return new UsersLogs();
        }
        //Check do already exist.
        $itemSaved = self::getByName($userId, $name);
        if (!empty($itemSaved->id)) {
            //Update previosly saved.
            return self::update($itemSaved, $name, $logs);
        }
        //Create new one.
        return self::create($userId, $name, $logs);
    }

    /**
     * Get logs by name.
     * @param int $userId
     * @param string $name
     * @return UsersLogs
     */
    public static function getByName(int $userId, string $name): UsersLogs {
        $nameSearch = SimpleFunctions::createSearchWord($name);
        $item = UsersLogs::where('user_id', $userId)->where('name_search', $nameSearch)->first();
        if(empty($item->id)){
            return new UsersLogs();
        }
        return $item;
    }

    /**
     * Get logs by ID.
     * @param int $userId
     * @param int $id
     * @return UsersLogs
     */
    public static function getById(int $userId, int $id): UsersLogs {
        $item = UsersLogs::find($id);
        if ($item->user_id != $userId) {
            return new UsersLogs();
        }
        return $item;
    }

    /**
     * Get list of user save logs.
     * @return \Illuminate\Database\Eloquent\Collection of UsersLogs
     */
    public static function getUserLogs(): \Illuminate\Database\Eloquent\Collection {
        $userId = self::getUserId();
        if (empty($userId)) {
            return new \stdClass();
        }
        return UsersLogs::where('user_id', $userId)->get();
    }

    /**
     * Create new user log.
     * @param int $userId
     * @param string $name
     * @param string $logs
     * @return UsersLogs
     */
    private static function create(int $userId, string $name, string $logs): UsersLogs {
        return UsersLogs::create([
                    'user_id' => $userId,
                    'name' => $name,
                    'name_search' => SimpleFunctions::createSearchWord($name),
                    'logs' => $logs,
        ]);
    }

    /**
     * Update user calculation log.
     * @param UsersLogs $itemSaved
     * @param int $userId
     * @param string $name
     * @param string $logs
     * @return UsersLogs
     */
    private static function update(UsersLogs $itemSaved, string $name, string $logs): UsersLogs {
        //Update previosly saved.
        $itemSaved->name = $name;
        $itemSaved->name_search = SimpleFunctions::createSearchWord($name);
        $itemSaved->logs = $logs;
        $itemSaved->save();
        return $itemSaved;
    }

}
