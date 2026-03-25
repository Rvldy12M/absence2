<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;

class RoleController extends Controller
{
    /**
     * Display list of roles
     */
    public function index()
    {
        return view('admin.roles');
    }

    /**
     * Get roles data for DataTables
     */
    public function data()
    {
        $query = Role::select([
            'roles.id',
            'roles.name',
            'roles.description',
            \DB::raw('COUNT(users.id) as user_count'),
            'roles.created_at',
            \DB::raw("'' as actions")
        ])
        ->leftJoin('users', 'roles.name', '=', 'users.role')
        ->groupBy('roles.id', 'roles.name', 'roles.description', 'roles.created_at');

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($query);

        $dt->edit('actions', function($data) {
            $id = $data['id'];
            return '
                <div class="flex justify-center space-x-2">
                    <a href="/admin/roles/'.$id.'" 
                       class="px-3 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 border border-blue-200 text-sm">View</a>
                    <a href="/admin/roles/'.$id.'/edit" 
                       class="px-3 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 border border-yellow-200 text-sm">Edit</a>
                    <form action="/admin/roles/'.$id.'" method="POST" class="inline delete-form">
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
     * Show create role form
     */
    public function create()
    {
        return view('admin.roles_create');
    }

    /**
     * Store role to database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama role harus diisi',
            'name.unique' => 'Nama role sudah ada',
            'name.max' => 'Nama role terlalu panjang',
            'description.max' => 'Deskripsi terlalu panjang',
        ]);

        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Show role details
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $users = User::where('role', $role->name)->get();
        
        return view('admin.roles_detail', compact('role', 'users'));
    }

    /**
     * Show edit role form
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles_edit', compact('role'));
    }

    /**
     * Update role
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama role harus diisi',
            'name.unique' => 'Nama role sudah ada',
            'name.max' => 'Nama role terlalu panjang',
            'description.max' => 'Deskripsi terlalu panjang',
        ]);

        // Jika nama role berubah, update juga di users
        if ($role->name !== $request->name) {
            User::where('role', $role->name)->update(['role' => $request->name]);
        }

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Delete role
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role berhasil dihapus.');
    }
}
