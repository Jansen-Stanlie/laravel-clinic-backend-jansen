<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->where('role', '!=', 'doctor') // Exclude users with the role "doctors"
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    //create
    public function create()
    {
        return view('pages.users.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        // Check if the email already exists
        $existingUser = User::where('email', $request->email)->exists();

        // If email already exists, display an alert
        if ($existingUser) {
            return redirect()->back()->with('error', 'Email is already registered.');
        }

        // Generate unique user ID
        $user_id = $this->generateUniqueUserId();

        // Create new user instance
        $user = new User();
        $user->user_id = $user_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        // Find all users and reorder IDs starting from 1
        $users = User::orderBy('id')->get();
        $count = 0;
        foreach ($users as $userToUpdate) {
            $count++;
            $userToUpdate->id = $count;
            $userToUpdate->save();
        }

        // Reset auto-increment for id column
        $maxId = User::max('id');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = ' . ($maxId + 1));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    //show
    public function show($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        return view('pages.users.show', compact('user'));
    }

    //edit
    public function edit($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        return view('pages.users.edit', compact('user'));
    }

    //update
    public function update(Request $request, $user_id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);

        // Log the request data
        Log::info('Request data:', $request->all());
        // Check if the email already exists
        $existingUser = User::where('email', $request->email)
            ->where('user_id', '!=', $request->user_id) // Exclude current user
            ->exists();

        // If email already exists, display an alert
        if ($existingUser) {
            return redirect()->back()->with('error', 'Email is already registered.');
        }

        try {
            $user = User::where('user_id', $request->user_id)->firstOrFail();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role = $request->role;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('error', $e);
        }
    }


    //destroy
    public function destroy($id)
    {
        // Find the user to be deleted
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Delete the user
        $user->delete();

        // Reassign user_id for all users to maintain sequential order
        $users = User::orderBy('id')->get();
        // $numericUserId = 0;
        // foreach ($users as $userToUpdate) {
        //     $numericUserId++;
        //     $userToUpdate->user_id = 'USR' . str_pad($numericUserId, 7, '0', STR_PAD_LEFT);
        //     $userToUpdate->save();
        // }

        // Reassign user_id for all users to randomly generated unique IDs
        // $users = User::all();
        // foreach ($users as $userToUpdate) {
        //     $userToUpdate->user_id = $this->generateUniqueUserId();
        //     $userToUpdate->save();
        // }

        // Reset the id column to start from 1
        // $count = 0;
        // foreach ($users as $userToUpdate) {
        //     $count++;
        //     $userToUpdate->id = $count;
        //     $userToUpdate->save();
        // }

        // // Reset auto-increment for id column
        // DB::statement('ALTER TABLE users AUTO_INCREMENT = ' . ($count + 1));

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function generateUniqueUserId()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';

        // Generate 3 random characters
        $random_characters = '';
        for ($i = 0; $i < 3; $i++) {
            $random_characters .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Generate 4 random digits
        $random_digits = '';
        for ($i = 0; $i < 4; $i++) {
            $random_digits .= $digits[rand(0, strlen($digits) - 1)];
        }

        // Combine characters and digits
        $user_id = $random_digits . $random_characters;

        // Check if the generated user_id already exists
        $existingUser = User::where('user_id', $user_id)->exists();

        // If generated user_id already exists, generate again
        if ($existingUser) {
            return $this->generateUniqueUserId();
        }

        return 'USR' . $user_id;
    }
}
