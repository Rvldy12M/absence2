<?php

// Test file to debug attendances endpoint
use App\Models\Attendance;

Route::get('/test-attendances', function() {
    $attendances = Attendance::select([
        'attendances.id',
        'attendances.location',
        'attendances.latitude',
        'attendances.longitude',
        'attendances.method',
    ])->limit(5)->get();
    
    return response()->json([
        'count' => count($attendances),
        'data' => $attendances,
    ]);
});
