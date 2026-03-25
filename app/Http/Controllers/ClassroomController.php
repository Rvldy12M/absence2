<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;

class ClassroomController extends Controller
{
    /**
     * Display list of classrooms
     */
    public function index()
    {
        return view('admin.classrooms');
    }

    /**
     * Get classrooms data for DataTables
     */
    public function data()
    {
        $query = Classroom::select([
            'classrooms.id',
            'classrooms.name',
            \DB::raw('COUNT(users.id) as student_count'),
            'classrooms.created_at',
            \DB::raw("'' as actions")
        ])
        ->leftJoin('users', function($join) {
            $join->on('classrooms.id', '=', 'users.class_id')
                 ->where('users.role', '=', 'student');
        })
        ->groupBy('classrooms.id', 'classrooms.name', 'classrooms.created_at');

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($query);

        $dt->edit('actions', function($data) {
            $id = $data['id'];
            return '
                <div class="flex justify-center space-x-2">
                    <a href="/admin/classrooms/'.$id.'" 
                       class="px-3 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 border border-blue-200 text-sm">View</a>
                    <a href="/admin/classrooms/'.$id.'/edit" 
                       class="px-3 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 border border-yellow-200 text-sm">Edit</a>
                    <form action="/admin/classrooms/'.$id.'" method="POST" class="inline delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="delete-btn px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 border border-red-200 text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            ';
        });

        $dt->edit('created_at', function($data) {
            return $data['created_at'];
        });

        return $dt->generate();
    }

    /**
     * Show create classroom form
     */
    public function create()
    {
        return view('admin.classrooms_create');
    }

    /**
     * Store classroom to database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name',
        ], [
            'name.required' => 'Nama kelas harus diisi',
            'name.unique' => 'Nama kelas sudah ada',
            'name.max' => 'Nama kelas terlalu panjang',
        ]);

        Classroom::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Show classroom details
     */
    public function show($id)
    {
        $classroom = Classroom::with('users')->findOrFail($id);
        $students = $classroom->users()->where('role', 'student')->get();
        
        return view('admin.classrooms_detail', compact('classroom', 'students'));
    }

    /**
     * Show edit classroom form
     */
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('admin.classrooms_edit', compact('classroom'));
    }

    /**
     * Update classroom
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name,' . $id,
        ], [
            'name.required' => 'Nama kelas harus diisi',
            'name.unique' => 'Nama kelas sudah ada',
            'name.max' => 'Nama kelas terlalu panjang',
        ]);

        $classroom->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Delete classroom
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
    }
}
