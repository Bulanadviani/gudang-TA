@extends ('layouts.app')
@section('content')
    <div class="container-fluid">

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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                            <h5>List Status</h5>
                            @can('pengaturan.create')
                                <div class="pl-3 border-left btn-new">
                                    <a href="#" class="btn btn-primary" data-target="#modal-tambah-status"
                                        data-toggle="modal">Add</a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====== Table Container ====== -->
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($status as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center ">
                                        <div class="d-flex align-items-center">
                                            @if ($item->jenis === 'peminjaman')
                                                <span class="badge badge-warning mr-2">{{ $item->jenis }}</span>
                                            @elseif($item->jenis === 'keluar')
                                                <span class="badge badge-danger mr-2">{{ $item->jenis }}</span>
                                            @else
                                                <span class="badge badge-primary mr-2">{{ $item->jenis }}</span>
                                            @endif

                                            <span> {{ $item->nama }}</span>

                                        </div>
                                        <div>
                                            @can('pengaturan.update')
                                                <button class="btn btn-sm btn-outline-primary" data-target="#modal-edit-status"
                                                    data-toggle="modal" data-item='@json($item)'
                                                    onclick="openEditModal(this)">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            @endcan

                                            @can('pengaturan.delete')
                                                <form method="post"
                                                    action="{{ url('/pengaturan/status/delete/' . $item->id) }}"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus Status?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                        </div>
                                    </li>
                                @endforeach
                                @if (count($status) === 0)
                                    <p class="h5">Belum ada Status</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ====== DataTables Initialization ====== -->


        {{-- MODAL CREATE --}}
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-tambah-status">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Tambah Status
                        </h3>
                    </div>
                    <form method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Status</label>
                                        <input type="text" name="nama" class="form-control" id="nama-status"
                                            placeholder="nama status" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="h5">Jenis</label>
                                        <select class="form-control" name="jenis">
                                            <option value="masuk">Masuk</option>
                                            <option value="keluar">Keluar</option>
                                            <option value="peminjaman">Peminjaman</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 gap-2">
                                        <button class="btn btn-primary mr-2" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button class="btn btn-success" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal EDIT -->
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-edit-status">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Edit Status
                        </h3>
                    </div>
                    <form action="{{ url('pengaturan/status/update/:id') }} " id="form-edit-status" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Status</label>
                                        <input type="text" name="nama" class="form-control" id="edit-nama-status"
                                            placeholder="nama status" />
                                    </div>
                                    <select class="form-control" id="edit-jenis-status" name="jenis">
                                        <option value="masuk">Barang Masuk</option>
                                        <option value="keluar">Barang Keluar</option>
                                        <option value="peminjaman">Peminjaman</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 ">
                                        <button class="btn btn-primary mr-2" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button class="btn btn-success" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            function openEditModal(el) {
                const item = JSON.parse(el.getAttribute('data-item'));
                const editForm = document.getElementById('form-edit-status')
                const inputName = document.getElementById('edit-nama-status')
                const inputJenis = document.getElementById('edit-jenis-status')
                inputName.value = item.nama
                inputJenis.value = item.jenis
                inputJenis.dispatchEvent(new Event('change'))
                editForm.action = editForm.action.replace(":id", item.id)
            }
        </script>
    @endpush
