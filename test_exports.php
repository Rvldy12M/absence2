<?php
// Quick test for exports

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Models/Classroom.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test Classrooms
    $classrooms = \App\Models\Classroom::withCount('users as student_count')->orderBy('name')->get();
    echo "✅ Classrooms count: " . $classrooms->count() . "\n";
    
    // Test Roles
    $roles = \App\Models\Role::withCount('users')->orderBy('name')->get();
    echo "✅ Roles count: " . $roles->count() . "\n";
    
    // Test Students  
    $students = \App\Models\User::where('role', 'student')->with('classroom')->orderBy('name')->get();
    echo "✅ Students count: " . $students->count() . "\n";
    
    // Test Users
    $users = \App\Models\User::whereIn('role', ['admin', 'guru'])->orderBy('role')->orderBy('name')->get();
    echo "✅ Users count: " . $users->count() . "\n";
    
    echo "\n✅ All exports can load data successfully!\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
