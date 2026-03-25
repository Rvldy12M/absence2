<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Helpers\GeolocationHelper;

class QRController extends Controller
{
    // Halaman form scan / input QR untuk siswa
    public function showForm()
    {
        return view('attendance.qr');
    }

    public function submit(Request $request)
    {
        // 🔹 Validasi awal
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // 🔹 Simpan foto
        $photoPath = $request->file('photo')->store('attendance_photos', 'public');
        $method = 'Photo';

        // 🔹 Data user & tanggal
        $user = Auth::user();
        $today = date('Y-m-d');

        // 🔹 Cegah absen ganda
        $already = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($already) {
            return back()->with('error', 'Kamu sudah absen hari ini');
        }

        // 🔹 Simpan ke database
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $status = 'Hadir';

        if ($now->greaterThan(\Carbon\Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta'))) {
            $status = 'Telat';
        }

        // Dapatkan nama lokasi dari latitude & longitude
        $location = null;
        if ($request->latitude && $request->longitude) {
            $location = GeolocationHelper::getLocationName($request->latitude, $request->longitude);
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'check_in_time' => now()->format('H:i:s'),
            'time' => now()->format('H:i:s'),
            'status' => $status,
            'photo' => $photoPath, // simpan path file
            'method' => $method,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location' => $location,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil dicatat');
    }

    // 🔹 Generate QR untuk admin
    public function generate()
    {
        $todayCode = 'HADIR-' . date('Ymd'); // kode unik harian
        $qr = QrCode::size(250)->generate($todayCode);

        return view('admin.qr', compact('qr', 'todayCode'));
    }
}
