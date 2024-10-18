<?php

namespace App\Http\Controllers;

use App\Models\User; // Ensure you import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search_user');
        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Logic to store the new user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,user', // Validasi untuk role
        ]);

        // Create the user...
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role, // Tambahkan role di sini
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,user', // Validasi untuk role
            'password' => 'nullable|string|min:6'
        ]);
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);


        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User deleted successfully');
        }
        return redirect()->route('user.index')->with('failed', 'User not found');
    }
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);

        if (Auth::attempt($user)) {
            // Check if the user has the required permissions
            $authenticatedUser = Auth::user();

            // Here, replace 'required_permission' with your actual permission check
            // if ($authenticatedUser->role !== 'admin') {
            //     return redirect()->route('error.permission'); // Redirect to permission error page
            // }

            return redirect()->route('home.page')->with('success', 'Login Telah Berhasil'); // Redirect to home page
        } else {
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }

    public function logout()
    {
        //menghapus session Auth
        Auth::logout();
        //mengarahkan halaman setelah menghapus session
        return redirect('/');
    }
}