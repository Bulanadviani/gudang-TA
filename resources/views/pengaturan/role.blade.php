@extends ('layouts.app')
@section ('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between breadcrumb-content">
                    <h5>List Role</h5>
                    @can('pengaturan.create')
                    <div class="pl-3 border-left btn-new">
                        <a href="#" class="btn btn-primary" data-target="#modal-create-role" data-toggle="modal">+ Create Role</a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- ====== Table Container ====== -->
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if ($roles->isEmpty())
                            <p class="h5">Belum ada Role</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($roles as $role)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $role->name }}</strong><br>
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge badge-info">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                        <div>
                                        @can('pengaturan.update')
                                            <button class="btn btn-sm btn-outline-primary"
                                                data-target="#modal-edit-role" data-toggle="modal"
                                                data-role='@json($role)'
                                                onclick="openEditModal(this)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @endcan
                                        @can('pengaturan.delete')
                                            <form method="POST" action="{{ route('pengaturan.role.delete', $role->id) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus Role?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE ROLE (UNCHANGED) --}}
    <div class="modal fade bd-example-modal-lg" role="dialog" id="modal-create-role">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bottom">
                    <h3 class="modal-title">Tambah Role</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('pengaturan.role.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" name="name" id="role_name" class="form-control" required>
                        </div>

                        <h5 class="mt-4">Permissions</h5>
                        @php
                            $permissions = [
                                'masuk' => ['view', 'create', 'update', 'delete'],
                                'keluar' => ['view', 'upload', 'update', 'delete'],
                                'peminjaman' => ['view', 'update', 'delete'],
                                'report' => ['view'],
                                'pengaturan' => ['view', 'create', 'update', 'delete'],
                                'users' => ['view', 'create', 'update', 'delete'],
                            ];
                        @endphp

                        @foreach ($permissions as $module => $actions)
                            <div class="card mt-3">
                                <div class="card-header font-weight-bold text-capitalize">{{ $module }}</div>
                                <div class="card-body">
                                    @foreach ($actions as $action)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                value="{{ $module . '.' . $action }}" id="{{ $module . '_' . $action }}">
                                            <label class="form-check-label" for="{{ $module . '_' . $action }}">
                                                {{ ucfirst($action) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-4">Create Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT ROLE --}}
    <div class="modal fade bd-example-modal-lg" role="dialog" id="modal-edit-role">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bottom">
                    <h3 class="modal-title">Edit Role</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form-edit-role" action="">
                        @csrf
        
                        <div class="form-group">
                            <label for="edit_role_name">Role Name</label>
                            <input type="text" name="name" id="edit_role_name" class="form-control" required>
                        </div>

                        <h5 class="mt-4">Permissions</h5>
                        @foreach ($permissions as $module => $actions)
                            <div class="card mt-3">
                                <div class="card-header font-weight-bold text-capitalize">{{ $module }}</div>
                                <div class="card-body">
                                    @foreach ($actions as $action)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input edit-permission-checkbox" type="checkbox" 
                                                name="permissions[]" value="{{ $module . '.' . $action }}" 
                                                id="edit_{{ $module . '_' . $action }}">
                                            <label class="form-check-label" for="edit_{{ $module . '_' . $action }}">
                                                {{ ucfirst($action) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function openEditModal(button) {
        const role = JSON.parse(button.getAttribute('data-role'));

        // Set form action with role id
        const form = document.getElementById('form-edit-role');
        form.action = "{{ url('pengaturan/role/update') }}/" + role.id;

        // Set role name input
        document.getElementById('edit_role_name').value = role.name;

        // Uncheck all checkboxes first
        document.querySelectorAll('.edit-permission-checkbox').forEach(cb => cb.checked = false);

        // Get role permission names for easy lookup
        const rolePermissions = role.permissions.map(p => p.name);

        // Check permissions that the role has
        document.querySelectorAll('.edit-permission-checkbox').forEach(cb => {
            if (rolePermissions.includes(cb.value)) {
                cb.checked = true;
            }
        });

        // Show the modal
        $('#modal-edit-role').modal('show');
    }
</script>
@endpush
