<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;

class UserController extends Controller
{
    /**
     * Display list of non-student users
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Get users data for DataTables (excluding students)
     */
    public function data()
    {
        $query = User::select([
            'users.id',
            'users.name',
            'users.email',
            'users.role',
            'users.created_at',
            \DB::raw("'' as actions")
        ])
        ->where('users.role', '!=', 'student');

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($query);

        $dt->edit('actions', function($data) {
            $id = $data['id'];
            return '
                <div class="flex justify-center space-x-2">
                    <a href="/admin/users/'.$id.'" 
                       class="px-3 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 border border-blue-200 text-sm">View</a>
                    <a href="/admin/users/'.$id.'/edit" 
                       class="px-3 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 border border-yellow-200 text-sm">Edit</a>
                    <form action="/admin/users/'.$id.'" method="POST" class="inline delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="delete-btn px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 border border-red-200 text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            ';
        });

        return $dt->generate();
    }

    /**
     * Show create user form
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'guru'])->get();
        return view('admin.users_create', compact('roles'));
    }

    /**
     * Store user to database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,guru',
        ], [
            'name.required' => 'Nama user harus diisi',
            'name.max' => 'Nama user terlalu panjang',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent showing student users
        if ($user->role === 'student') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak ditemukan.');
        }

        return view('admin.users_detail', compact('user'));
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent editing student users
        if ($user->role === 'student') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak ditemukan.');
        }

        $roles = Role::whereIn('name', ['admin', 'guru'])->get();
        return view('admin.users_edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent editing student users
        if ($user->role === 'student') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,guru',
        ];

        // Password is optional on update
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $request->validate($rules, [
            'name.required' => 'Nama user harus diisi',
            'name.max' => 'Nama user terlalu panjang',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting student users
        if ($user->role === 'student') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak ditemukan.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
