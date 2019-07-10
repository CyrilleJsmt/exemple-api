<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User as User;

class UserController 
{
    public function all() {
        $allusers = User::all();
        return response()->json(['error' => false, 'message' => '', 'data' => $allusers], 200);
    }

    public function userById($id) {
        $user = User::where('ID', 'like', '%'.$id.'%')->orWhere('Name', 'like', '%'.$id.'%')->get();
        return response()->json(['error' => false, 'message' => '', 'data' => $user], 200);
    }

    public function userByName($name) {
        $query = User::where('Name', '=', $name)->get();
        if(!$query) {
            return response()->json(['error' => true, 'message' => 'Aucun utilisateur pour ce nom.', 'data' => null], 404);
        } else {
            return response()->json(['error' => false, 'message' => '', 'data' => $query], 200);
        }
    }
}