<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Libraries\UsersLogsBLL;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isAuthorised = Auth::check();
        $savedLogs = null;
        if ($isAuthorised){
            $savedLogs = UsersLogsBLL::getUserLogs();
        }
        return view('home', [
            'isAuthorised' => $isAuthorised,
            'savedLogs' => $savedLogs,
        ]);
    }
    
    
    /**
     * Save logs.
     * @return JSON
     */
    public function logSave(Request $request){
        $requestPost = $request->request->all();
        //Validate
        if (empty($requestPost['name']) || empty($requestPost['logs'])){
            return response()->json(['error' => true]);
        }
        //Save
        $item = UsersLogsBLL::saveLogs($requestPost['name'], $requestPost['logs']);
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
        ]);
    }
    
    /**
     * Load logs by ID.
     * @return JSON
     */
    public function logLoadById(Request $request){
        $requestPost = $request->request->all();
        //Validate
        if (empty($requestPost['id'])){
            return response()->json(['error' => true]);
        }
        $userId = UsersLogsBLL::getUserId();
        $item = UsersLogsBLL::getById($userId, $requestPost['id']);
        if (empty($item)){
            return response()->json(['error' => true]);
        }
        return response()->json([
            'logs' => $item->logs,
        ]);
    }
    
    /**
     * Load log by name.
     * @return JSON
     */
    public function logLoadByName(Request $request){
        $requestPost = $request->request->all();
        //Validate
        if (empty($requestPost['name'])){
            return response()->json(['error' => true]);
        }
        $userId = UsersLogsBLL::getUserId();
        $item = UsersLogsBLL::getByName($userId, $requestPost['name']);
        if (empty($item)){
            return response()->json(['error' => true]);
        }
        return response()->json([
            'logs' => $item->logs,
            'name' => $item->name,
        ]);
    }
}
