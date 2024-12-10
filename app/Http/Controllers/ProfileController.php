<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Edit the authenticated user's profile
    public function edit()
    {
        $user = auth()->user(); // Get the logged-in user
        return view('profile.edit', compact('user'));
    }


public function update(Request $request)
{
    // Get the authenticated user
    /** @var User $user */
    $user = auth()->user();
    Log::info('Authenticated User:', $user->toArray());

    // Validate the request
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    ]);

    // Update the user's profile manually
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->save(); // Save to the database

    // Log the updated user
    Log::info('Updated User:', $user->fresh()->toArray());

    return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
}





    // Admin edits any user's profile
    public function adminEdit(User $user)
    {
        return view('admin.profile.edit', compact('user'));
    }

    // Admin updates any user's profile
    public function adminUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.profile.edit', $user)->with('success', 'User profile updated successfully!');
    }
}
