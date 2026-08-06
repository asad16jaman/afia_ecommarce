<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::latest()->get();
            return view('admin.auth.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the users. Please try again later.');
        }
    }

    public function create()
    {
        try {
            $users = User::latest()->get();
            return view('admin.auth.create', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error displaying create user page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create user page. Please try again later.');
        }
    }


    public function store(Request $request)
    {
        // Log::debug('Registration Request Data:', $request->all());

        // $this->validate($request, [
        //     'name' => 'required|string|max:60',
        //     'email' => 'required|email|max:60|unique:users,email',
        //     'username' => 'required|string|unique:users,username',
        //     'phone' => 'nullable|string|max:20',
        //     'password' => 'required|min:8|confirmed',
        //     'address' => 'nullable|string|max:500',
        //     'type' => 'required|in:admin,user',
        //     'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        // ]);

        

        $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:60|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'type' => 'required|in:admin,user',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // try {

            $file = $request->file('image');
            $imagePath = $this->uploadImg($file,'uploads/user');

            $data = $request->only('name','email','username','phone','type');
            $data['password'] = Hash::make($request->password);
            $data['image'] = $imagePath;
            $data['ip_address'] = $request->ip();
            $data['status'] = 'a';
            
            $user = User::create($data);

            // $user = User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'username' => $request->username,
            //     'phone' => $request->phone,
            //     'password' =>  Hash::make($request->password),
            //     'address' => $request->address,
            //     'type' => $request->type,
            //     'ip_address' => $request->ip(),
            //     'image' => $imagePath,
            // ]);

            Log::debug('User created successfully, user data:', $user->toArray());

            return redirect()->back()->with('success', 'User created successfully.');

        // } catch (\Throwable $th) {
        //     Log::error('User registration failed', [
        //         'error' => $th->getMessage(),
        //         'stack_trace' => $th->getTraceAsString(),
        //     ]);
        //     return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        // }

    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.auth.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error fetching user for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the user. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'username' => 'required|string|unique:users,username,' . $id,
                'phone' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                'type' => 'required|in:admin,user',
            ]);

            $imagePath = $user->image;
            if ($request->hasFile('image')) {

                if (File::exists($user->image)) {
                    File::delete($user->image);
                }

                $file = $request->file('image');
                $imagePath = $this->uploadImg($file,'uploads/user');
            }

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'type' => $request->type,
                'image' => $imagePath,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            Log::debug('User updated successfully, user data:', $userData);


            return redirect()->route('users.create')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating user: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'An unexpected error occurred while updating the user. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,p,d',
            ]);

            $user->status = $request->status;
            $user->save();

            return back()->with('success', 'User status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating user status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function updateAccess(Request $request, User $user)
    {
        $request->validate([
            'access' => 'nullable|array',
            'access.*' => 'string'
        ]);

        $accessJson = json_encode($request->access);

        $userAccess = UserAccess::updateOrCreate(
            ['user_id' => $user->id],
            ['access' => $accessJson]
        );

        return redirect()->back()->with('success', 'User access updated successfully.');
    }

}
