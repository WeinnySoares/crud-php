<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create($dados){
        $user = new User;
        $user->name = 'Gi';
        $user->email = 'gi@gmail.com';
        $user->password = Hash::make('123');
        $user->save();
    }

    public function all()
    {   //$this->create('test');
        $user = User::where('id','=',1)->first();
        return view('user',[
            'user'=>$user
        ]);
    }
}
