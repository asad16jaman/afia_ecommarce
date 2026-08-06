<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{
    // use Utils;

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        try {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if ($user->status === 'p') {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Your account is pending.');
                }

                if ($user->status === 'd') {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Your account is deactivate.');
                }

                return redirect()->intended('/dashboard');
            }

            return redirect()->back()->withInput($request->only('username'))
                ->with('error', 'Username or Password was invalid.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            // 'username' => 'required|unique:users,username,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->hasFile('image')) {
                if (!empty($user->image) && file_exists($user->image)) {
                    unlink($user->image);
                }
                $file =$request->file('image');
                $user->image = $this->uploadImg($file,'uploads/user');
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            // $user->username = $request->username;

            $user->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function showChangePasswordForm()
    {
        return view('admin.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages(['current_password' => 'Current password is incorrect.']);
        }

        User::find(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('password.change')->with('success', 'Password updated successfully!');
    }
}
