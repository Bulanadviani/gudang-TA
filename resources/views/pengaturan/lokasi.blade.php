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
                            <h5>List Lokasi</h5>
                            @can('pengaturan.create')
                                <div class="pl-3 border-left btn-new">
                                    <a href="#" class="btn btn-primary" data-target="#modal-tambah-lokasi"
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
                                @foreach ($lokasi as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center ">
                                        <span> {{ $item->nama }}</span>
                                        <div>
                                            @can('pengaturan.update')
                                                <button class="btn btn-sm btn-outline-primary" data-target="#modal-edit-lokasi"
                                                    data-toggle="modal" data-item='@json($item)'
                                                    onclick="openEditModal(this)">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            @endcan
                                            @can('pengaturan.delete')
                                                <form method="post"
                                                    action="{{ url('/pengaturan/lokasi/delete/' . $item->id) }}"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus Lokasi?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </li>
                                @endforeach
                                @if (count($lokasi) === 0)
                                    <p class="h5">Belum ada Lokasi</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ====== DataTables Initialization ====== -->


        {{-- MODAL CREATE --}}
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-tambah-lokasi">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Tambah Lokasi
                        </h3>
                    </div>
                    <form method="post" action="{{ url('pengaturan/lokasi') }}">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Lokasi</label>
                                        <input type="text" name="nama" class="form-control" id="nama-lokasi"
                                            placeholder="nama lokasi" />
                                        @error('nama')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
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
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-edit-lokasi">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Edit Lokasi
                        </h3>
                    </div>
                    <form action="{{ url('pengaturan/lokasi/update/:id') }}"
                        data-base-action="{{ url('pengaturan/lokasi/update/:id') }}" id="form-edit-lokasi" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Lokasi</label>
                                        <input type="text" name="nama" class="form-control" id="edit-nama-lokasi"
                                            placeholder="nama lokasi" />
                                    </div>
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
            $(document).ready(function() {
                // Tampilkan modal otomatis kalau ada error validasi
                @if ($errors->any())
                    $('#modal-tambah-lokasi').modal('show');
                @endif

                // Delegasikan event keydown ke document, untuk #nama-lokasi
                $(document).on('keydown', '#nama-lokasi', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        $(this).closest('form').submit();
                    }
                });

                // Bersihkan form saat modal ditutup
                $('#modal-tambah-lokasi').on('hidden.bs.modal', function() {
                    $(this).find('.is-invalid').removeClass('is-invalid');
                    $(this).find('.text-danger').remove();
                    $(this).find('input').val('');
                });

                // Reset form saat modal dibuka
                $('#modal-tambah-lokasi').on('show.bs.modal', function() {
                    $(this).find('form')[0].reset();
                });
            });

            // Fungsi untuk modal edit
            function openEditModal(el) {
                const item = JSON.parse(el.getAttribute('data-item'));
                const editForm = document.getElementById('form-edit-lokasi')
                const inputName = document.getElementById('edit-nama-lokasi')
                inputName.value = item.nama
                editForm.action = editForm.action.replace(":id", item.id)
            }
        </script>
    @endpush
