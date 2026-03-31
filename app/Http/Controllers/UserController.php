<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
{
    $data = $request->validated();

    $name = trim($data['first_name'] . ' ' . $data['last_name']);

    $user = User::create([
        'name'      => $name,
        'email'     => $data['email'] ?? null,
        'phone'     => $data['phone'],
        'password'  => Hash::make($data['password']),
    ]);

    return response()->json([
        'message' => 'User registered successfully',
        'user'    => $user,
    ], 201);
}


    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('phone', $data['phone'])->first();

    if (! $user || ! Hash::check($data['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid phone or password',
            'status'  => 401,
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user'    => [
        'id'        => $user->id,
        'name'      => $user->name,
        'email'     => $user->email,
        'phone'     => $user->phone,
        'token'   => $token,
        ]
        ], 200);
    }
    public function logout(Request $request)
    {
       $request->user()->currentAccessToken()->delete();
       return response()->json([
            'message'=>'Logut  successful',]);
    }


    public function profile(Request $request)
    {
        $user=$request->user();
        return response()->json([
            'user' => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                'role'      => $user->role,
                'address'   => $user->address,
                'region_id' => $user->region_id,
            ],
        ]);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data=$request->validated();
    
        if (isset($data['first_name']) || isset($data['last_name']))//اذا المستخدم ارسل الاسم الاول او الثاني
             {
            [$oldFirst, $oldLast] = array_pad(explode(' ', $user->name, 2), 2, '');//يقسم الاسم لأول جزئين (أول كلمة = first، الباقي = last).  
                                                                 //ثم يتاكد ان الناتج فيه عنصرين دائما

            $first = $data['first_name'] ?? $oldFirst;//في حال المستخدم لم يقم بتغيير الاسم الأول نبقيه على حالته السابقة
            $last  = $data['last_name']  ?? $oldLast;

            $user->name = trim($first . ' ' . $last);
        }

        if (array_key_exists('email', $data)) {
            $user->email = $data['email'];
        }

        if (array_key_exists('phone', $data)) {
            $user->phone = $data['phone'];
        }

        if (array_key_exists('address', $data)) {
            $user->address = $data['address'];
        }

        if (array_key_exists('region_id', $data)) {
            $user->region_id = $data['region_id'];
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                'role'      => $user->role,
                'address'   => $user->address,
                'region_id' => $user->region_id,
                ]
        ]);
    }
     public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        // التحقق من كلمة السر الحالية
        if (! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
}
    
