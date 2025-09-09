<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;


class userController extends Controller
{
    public function index($role = null)
{
    $users = User::with('role')
                ->when($role, fn($q) => $q->whereHas('role', fn($r) => $r->where('name', $role)))
                ->get();

    return view('dashboard', [
        'users' => $users,
        'totalStudents' => User::whereHas('role', fn($q) => $q->where('name', 'student'))->count(),
        'totalTeachers' => User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count(),
        'totalAdmins' => User::whereHas('role', fn($q) => $q->where('name', 'admin'))->count(),
    ]);
}

public function userEdit($id){
     $user = User::findOrFail($id);

        return view('users.editUser');
}

    public function listUsers($role)
    {
        // Get users where their related role's name matches the passed role
        $users = User::whereHas('role', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();

        return view('dashboard', compact('users'));
    }

    //Show Attendance
    public function showAttendance()
{
    $today = now()->toDateString(); // Get today's date

    $attendances = User::whereHas('role', function ($query) {
        $query->where('name', 'student');
    })
    ->whereDoesntHave('Attendance', function ($query) use ($today) {
        $query->whereDate('date', $today);
    })
    ->get();

    return view('dashboard', compact('attendances'));
}

public function showMarkAttendance(Request $request)
{
    if($request == ""){
    $date = now()->toDateString();
    }
    else{
    $date = $request->input('date', now()->toDateString());
    }
    $markAttendances = User::whereHas('role', function ($query) {
        $query->where('name', 'student');
    })
    ->whereHas('attendance', function ($query) use ($date) {
        $query->whereDate('date', $date);
    })
    ->with(['attendance' => function ($query) use ($date) {
        $query->whereDate('date', $date);
    }])
    ->get();
    
    return view('dashboard',['markAttendances' => $markAttendances,
        'role'=>'markAttendance']);
}

    public function storeAttendance($id, Request $request)
    {
        $status = $request->input('status');
        $check = $request->input('update');

        if ($check == 'update') {
            Attendance::where('stu_id', $id)
                ->where('date', now()->toDateString())
                ->update(['status' => $status]);

            return redirect()->route('show.markAttendance', ['role' => 'markAttendance'])
                ->with('success', 'Attendance updated successfully.');
        } else {
            Attendance::updateOrCreate(
                ['stu_id' => $id, 'date' => now()->toDateString()],
                ['status' => $status]
            );
            return redirect()->route('show.attendance', ['role' => 'attendance'])
                ->with('success', 'Attendance marked successfully.');
        }
    }

}
