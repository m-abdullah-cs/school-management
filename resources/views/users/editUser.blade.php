<x-guest-layout>
    <form action="{{ route('userUpdate', $user->id) }}" method="POST">
                    @csrf
                    <!-- @method('PATCH') is used to tell Laravel to treat this as a PATCH request,
                         which is the standard for updating a resource. -->
                    @method('PATCH')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field (using a dropdown) -->
                    <div class="mb-6">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                        <select id="role" name="role"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="student" {{ optional($user->role)->name == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ optional($user->role)->name == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="admin" {{ optional($user->role)->name == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update User
                        </button>
                        <!-- The cancel button links back to the user list.
                             You may need to adjust the route name here. -->
                        <a href="{{ route('dashboard') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
</x-guest-layout>
