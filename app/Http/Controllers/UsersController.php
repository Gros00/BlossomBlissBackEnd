<?php

namespace App\Http\Controllers;


use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UsersController extends Controller
{
    public function create(Request $request)
    {
        Users::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'ты создан, идиот',
        ]);
    }

    public function login(Request $request){
        $user = Users::where('phone', $request->phone)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Неверный логин или пароль'
            ], 401);
        }

        if($user->email===null){
            $user->email = '';
        }
        if($user->address===null){
            $user->address = '';
        }
       return response()->json([
           "phone"=>$user->phone,
           "id"=>$user->id,
           "name"=>$user->name,
           "address"=>$user->address,
           "email"=>$user->email,
       ]);
    }
    public function changePassword(Request $request){
        $user = Users::find($request->id);
        if(!$user || !Hash::check($request->lastPassword, $user->password)){
            return response()->json([
                'message'=>'неверный пароль',
            ]);
        }
        $user->password = Hash::make($request->newPassword);
        $user->save();
        return response()->json([
            'user'=>$user,
            'message'=>'пароль успешно обновлён'
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = Users::find($request->id);

        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден',
            ], 404);
        }
        $user->email = $request->email ?? $user->email;
        $user->address = $request->address ?? $user->address;
        $user->name = $request->name ?? $user->name;
        $user->save();

        return response()->json([
            'user' => $user,
        ]);
    }
}
