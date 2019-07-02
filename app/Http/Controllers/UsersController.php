<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    public function update(UserUpdateRequest $request, User $user, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        
        if($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if($result) {
                $data['avatar'] = $result['path'];
            }
        }
        
        $user->update($data);
        return redirect()->route('users.show', Auth::id())->with('success', '个人信息修改成功 ^_^');
    }
}
