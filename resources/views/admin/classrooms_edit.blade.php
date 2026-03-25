@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="max-w-lg mx-auto py-8 px-6">
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Edit Kelas</h2>
            <p class="text-slate-600 text-sm mt-1">Perbarui informasi kelas: {{ $classroom->name }}</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.classrooms.update', $classroom->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Kelas -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $classroom->name) }}"
                       placeholder="Contoh: X A, X B, XI A, dll"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.classrooms.index') }}" 
                   class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    Perbarui Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
