<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
    @if(Auth::user()->role->name != 'student')
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">User Management</h2>
<nav class="space-y-4">
    <!-- Students -->
    <a href="{{ route('showAllUsers', ['role' => 'student']) }}"
       class="block bg-blue-50 p-4 rounded-lg shadow hover:shadow-md transition">
        <div class="text-center">
            <div class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-md inline-block transition">
                Students
            </div>
        </div>
    </a>

    <!-- Teachers -->
    <a href="{{ route('showAllUsers', ['role' => 'teacher']) }}"
       class="block bg-green-50 p-4 rounded-lg shadow hover:shadow-md transition">
        <div class="text-center">
            <div class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-md inline-block transition">
                Teachers
            </div>
        </div>
    </a>

    <!-- Admin -->
    <a href="{{ route('showAllUsers', ['role' => 'admin']) }}"
       class="block bg-red-50 p-4 rounded-lg shadow hover:shadow-md transition">
        <div class="text-center">
            <div class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-md inline-block transition">
                Admin
            </div>
        </div>
    </a>

    {{-- <!-- Attendance -->
    <a href="{{route('show.attendance',['role' => 'attendance'])}}"
       class="block bg-pink-50 p-4 rounded-lg shadow hover:shadow-md transition">
        <div class="text-center">
            <div class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-semibold py-2 px-4 rounded-md inline-block transition">
                Attendance
            </div>
        </div>
    </a> --}}

    <!-- Attendance (Collapsible) -->
<div x-data="{ open: false }" class="block bg-pink-50 rounded-lg shadow hover:shadow-md transition">
    <!-- Main Attendance Link (Toggles submenu) -->
    <button @click="open = !open" class="w-full text-left p-4">
        <div class="text-center">
            <div class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-semibold py-2 px-4 rounded-md inline-block transition">
                Attendance
            </div>
        </div>
    </button>

    <!-- Sub-links (visible when open) -->
    <div x-show="open" x-transition class="pl-6 pb-4">
        <!-- Show Attendance -->
        <a href="{{route('show.markAttendance',['role' => 'markAttendance'])}}" class="block text-sm text-pink-700 hover:underline mt-2">
            View Attendance
        </a>

        <!-- Mark Attendance -->
        <a href="{{route('show.attendance',['role' => 'attendance'])}}" class="block text-sm text-pink-700 hover:underline mt-2">
            Mark Attendance
        </a>
    </div>
</div>

</nav>

        </aside>
    @endif
        <main class="flex-1 p-6">
         @if (empty(request()->route('role')) && request('role') != 'attendance' && request('role') != 'markAttendance')
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600">This is your dashboard. Use the sidebar to manage users.</p>
            </div>
        @endif
            <div class="flex items-center justify-between mb-4">
            @if (!empty(request()->route('role')))
                <h2 class="text-xl font-semibold text-gray-800">
        All {{ ucfirst(request()->route('role') ?? 'Users') }}
    </h2>
            @endif
    
    @if(request()->route('role'))
    <a href="{{route('userAdd',['role'=>request()->route('role')])}}" class="inline-block btn btn-primary bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded-md shadow">
        Add {{ ucfirst(request()->route('role')) }}
    </a>
@endif
</div>

@if(Auth::user()->role->name != 'student' && request('role') != 'attendance' && request('role') != 'markAttendance')
    @if (empty(request()->route('role')))
        <div class="flex flex-wrap gap-6 mb-6">
            <div class="w-40 h-40 flex flex-col justify-center items-center bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded shadow-sm">
                <div class="text-sm font-semibold">Total Students</div>
                <div class="text-2xl font-bold">{{$totalStudents ?? '0'}}</div>
            </div>

            <div class="w-40 h-40 flex flex-col justify-center items-center bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                <div class="text-sm font-semibold">Total Teachers</div>
                <div class="text-2xl font-bold">{{$totalTeachers ?? '0'}}</div>
            </div>
        </div>
    @endif
@endif

@if(Auth::user()->role->name == 'student')
    <div class="card shadow-sm border-0 mt-4" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="card-title mb-3 text-primary">
                <i class="bi bi-calendar-check-fill me-2"></i>Mark Your Attendance
            </h5>
            <p class="card-text text-muted">Please confirm your presence for today.</p>
            <a href="{{route('attendance.submit')}}" class="btn btn-primary btn-sm">
                <i class="bi bi-check2-circle me-1"></i> Submit Attendance
            </a>
        </div>
    </div>
@endif

                <div class="overflow-x-auto">
                @if (!empty(request()->route('role')))
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst(optional($user->role)->name) ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $user->created_at ? $user->created_at->format('Y-m-d') : "N/A" }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                    <td class="px-4 py-2 text-sm text-gray-700">
                <div class="d-flex align-items-center">
        <a href="{{route('userEdit',$user->id)}}" class="btn btn-primary btn-sm me-2">
            Edit
        </a>
        <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                Delete
            </button>
        </form>
    </div>
</td>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            
@if(request('role') == 'attendance' && isset($attendances))
<div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($attendances as $user)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                    <div class="d-flex align-items-center">
        <form action="{{ route('store.attendance', $user->id) }}" method="POST" class="inline-block me-2">
            @csrf
            <input type="hidden" name="status" value="present">
            <button type="submit" class="btn btn-success btn-sm">Present</button>
        </form>

        <form action="{{ route('store.attendance', $user->id) }}" method="POST" class="inline-block me-2">
            @csrf
            <input type="hidden" name="status" value="absent">
            <button type="submit" class="btn btn-danger btn-sm">Absent</button>
        </form>
        
    </div>
</td>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                @endif

@if(request('role') == 'markAttendance')
<div class="overflow-x-auto">
<div class="mb-4">
    <form method="GET" action="{{route('show.markAttendance',['role' => 'markAttendance'])}}" class="flex items-center gap-4">
        <input type="hidden" name="role" value="markAttendance">
        <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}" class="border border-gray-300 rounded px-3 py-2 text-sm" />
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded">
            Filter by Date
        </button>
    </form>
</div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                    
                        @forelse($markAttendances as $user)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->id }}</td>
                               
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->attendance->first()->status ?? 'N/A' }}</td>
                                    

                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                    {{-- <a href="{{route('store.attendance',$user->id)}}" class="btn btn-primary btn-sm me-2">
                                        Update Attendance
                                    </a> --}}
                                    <button 
            class="btn btn-primary btn-sm me-2"
            data-bs-toggle="modal" 
            data-bs-target="#attendanceModal"
            data-user-id="{{ $user->id }}"
            data-user-name="{{ $user->name }}"
            data-user-status="{{$user->attendance->first()->status}}"
        >
            Update Attendance
        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No users found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    </div>
                     @endif
                </div>
            </div>
        </main>
    </div>
<!-- Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="/attendance/mark/__USER_ID__" id="attendanceForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="attendanceModalLabel">Update Attendance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Student Name: <strong id="userNamePlaceholder"></strong></p>
            <input type="hidden" name="update" value="update">
          <div class="mb-3">
            <label for="status" class="form-label">Attendance Status</label>
            <select class="form-select" name="status" id="status" required>
              <option value="present">Present</option>
              <option value="absent">Absent</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const attendanceModal = document.getElementById('attendanceModal');
    attendanceModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        const status = button.getAttribute('data-user-status');

        // Update the modal form's action
        const form = attendanceModal.querySelector('#attendanceForm');
        const baseAction = "/attendance/mark/__USER_ID__";
        form.action = baseAction.replace("__USER_ID__", userId);

        // Update the user name in the modal
        const userNamePlaceholder = attendanceModal.querySelector('#userNamePlaceholder');
        userNamePlaceholder.textContent = userName;
    });
});
</script>

</x-app-layout>