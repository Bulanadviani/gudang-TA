@extends('layouts.app')
@section('content')
    <form autocomplete="off" action="{{ url('users/' . $users->id) }}" method="post">
        {!! csrf_field() !!}
        @method('PATCH')
        <div class="card card-body">
            <div class="row">
                {{-- Name --}}
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="name" class="h5">Nama*</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Nama" value="{{ old('name', $users->name) }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="email" class="h5">Email*</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Email" value="{{ old('email', $users->email) }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Role --}}
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="role" class="h5">Role*</label>
                        <select name="role" class="form-control @error('role') is-invalid @enderror" id="role"
                            required>
                            <option value="" disabled {{ $users->roles->isEmpty() ? 'selected' : '' }}>-- Pilih Role
                                --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $users->roles->first()?->name === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- Password --}}
                <div class="col-12">
                    <em>Jika Ingin Mengubah password silahkan mengisi inputan di bawah</em>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="password" class="h5">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="h5">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                            placeholder="Confirm Password" />
                    </div>
                </div>

                {{-- Hidden User ID --}}
                <input type="hidden" name="user_id" value="{{ Crypt::encrypt($users->id) }}">

                {{-- Submit --}}
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                        <input class="btn btn-success gap-2" type="submit" value="Update">
                        <a href="{{ route('users.index') }}" class="btn btn-primary ml-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
