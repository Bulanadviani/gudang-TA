@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>User</h5>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="list-grid-toggle d-flex align-items-center mr-3">
                                <div data-toggle-extra="tab" data-target-extra="#grid" class="toggle-view toggle-grid active">
                                    <div class="grid-icon mr-3">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                    </div>
                                </div>
                                <div data-toggle-extra="tab" data-target-extra="#list" class="toggle-view toggle-list">
                                    <div class="grid-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <line x1="8" y1="6" x2="21" y2="6" />
                                            <line x1="8" y1="12" x2="21" y2="12" />
                                            <line x1="8" y1="18" x2="21" y2="18" />
                                            <circle cx="3.5" cy="6" r="1.5" />
                                            <circle cx="3.5" cy="12" r="1.5" />
                                            <circle cx="3.5" cy="18" r="1.5" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @can('users.create')
                                <div class="pl-3 border-left btn-new">
                                    <a href="#" class="btn btn-primary" data-toggle="modal"
                                        data-target="#new-project-modal">Tambah User</a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
        <div class="row">
            @foreach ($users as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <h5 class="mb-1">{{ $item->name }}</h5>
                            <p class="mb-3">{{ $item->email }}</p>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                                <div class="iq-media-group">
                                    <span class="iq-media d-flex align-items-center">
                                        <div
                                            class="avatar avatar-40 rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mr-1">
                                            {{ strtoupper(collect(explode(' ', $item->name))->take(2)->map(fn($word) => substr($word, 0, 1))->implode('')) }}
                                        </div>
                                        <div>
                                            @foreach ($item->roles as $role)
                                                <span class="text-primary mr-2">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </span>
                                </div>
                                <span>
                                    @can('users.delete')
                                        <button class="btn btn-white text-primary link-shadow bg-danger btn-delete-user"
                                            data-id="{{ $item->id }}" title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        </form>
                                    @endcan
                                    @can('users.update')
                                        <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Edit User"
                                            class="btn btn-white text-primary link-shadow bg-warning text-white ml-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MODAL CREATE --}}
    <div class="modal fade bd-example-modal-lg" id="new-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center pb-3 border-bottom d-block">
                    <h3 class="modal-title" id="exampleModalCenterTitle02">Tambah User</h3>
                    <button type="button" class="close position-absolute" style="right:15px;top:15px;"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('users') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="h5">Name*</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Name" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="email" class="h5">Email*</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Email" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="password" class="h5">Password*</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" required />
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="h5">Confirm Password*</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Confirm Password" required />
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="role" class="h5">Role*</label>
                                    <select name="role" class="form-control" id="role" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->any())
        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#new-project-modal').modal('show');
                });
            </script>
        @endpush
    @endif
    <div id="list" class="item-content animate__animated animate__fadeIn d-none" data-toggle-extra="tab-content">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @foreach ($item->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('users.update')
                                    <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Edit User"
                                        class="btn btn-white text-primary link-shadow bg-warning text-white ml-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcan
                                @can('users.delete')
                                    <button class="btn btn-white text-primary link-shadow bg-danger btn-delete-user"
                                        data-id="{{ $item->id }}" title="Hapus User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.toggle-view').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('.toggle-view').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    document.querySelectorAll('[data-toggle-extra="tab-content"]').forEach(el => el.classList
                        .add('d-none'));
                    const target = button.getAttribute('data-target-extra');
                    document.querySelector(target).classList.remove('d-none');
                });
            });

            $(document).on('click', '.btn-delete-user', function() {
                const userId = $(this).data('id');
                Swal.fire({
                    title: "Yakin ingin menghapus user ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/users/${userId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'User berhasil dihapus',
                                }).then(() => {
                                    location
                                        .reload(); // Atau kamu bisa hapus elemennya tanpa reload
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
