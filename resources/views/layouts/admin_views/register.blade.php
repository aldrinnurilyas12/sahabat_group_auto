

<x-guest-layout style="position: absolute;">

     
    <h2 style="margin-bottom: 20px; color:white; font-weight:bold;">DAFTAR AKUN USER ADMIN <b> SAHABAT GROUP</b></h2>
    <form method="POST" action="{{ route('save_users') }}">
        @csrf

        <div class="mt-4">
            <x-input-label for="Pilih Karyawan" :value="__('Pilih Karyawan')" />
            <select 
                id="employee" 
                name="employee_id" 
                class="block mt-1 w-full" 
                required 
                autocomplete="employee"
            >
                <option value="" disabled selected>Select a employee</option>
                @foreach($employees as $emp)
                    <option 
                        value="{{ $emp->id }}" 
                        {{ old('employee') == $emp->id ? 'selected' : '' }}
                    >
                        {{ $emp->nik }} - {{ $emp->name }}

                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('employee')" class="mt-2" />
        </div>

        <!-- Nik -->
        <div class="mt-4">
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input aria-placeholder="Masukan NIK" id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required autofocus autocomplete="off" />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>
        </div>

        <!-- Role -->

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select 
                id="role" 
                name="role" 
                class="block mt-1 w-full" 
                required 
                autocomplete="role"
            >
                <option value="" disabled selected>Select a role</option>
                @foreach($roles as $role)
                    <option 
                        value="{{ $role->id }}" 
                        {{ old('role') == $role->id ? 'selected' : '' }}
                    >
                        {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password  --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div> 


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    
</x-guest-layout>


