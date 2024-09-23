<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.user.index',[
            'users' => User::all()
           ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get all input data
        $data = $request->all();

        // Ensure division_id is set to 1 if it's not provided
        $data['division_id'] = 1;

        // Save the user to the database
        User::create($data);

        return redirect('/dashboard/user')->with('success', 'New user has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Return the edit view with the user's data
        return view('dashboard.user.edit', compact('user'));
    }

    // Handle the form submission to update a user
    public function update(Request $request, $id)
    {
        // Validate the request input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8', // Optional password field
        ]);

        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Update the user's data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        // If the password field is filled, update the password
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Save the changes to the database
        $user->save();

        // Redirect back to the user list with a success message
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/dashboard/user')->with('success','User has been deleted!');
    }
}
