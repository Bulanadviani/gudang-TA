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
                            <h5>List Merk</h5>
                            @can('pengaturan.create')
                                <div class="pl-3 border-left btn-new">
                                    <a href="#" class="btn btn-primary" data-target="#modal-tambah-merk"
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
                                @foreach ($merk as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center ">
                                        <span> {{ $item->nama }}</span>
                                        <div>
                                            @can('pengaturan.update')
                                                <button class="btn btn-sm btn-outline-primary" data-target="#modal-edit-merk"
                                                    data-toggle="modal" data-item='@json($item)'
                                                    onclick="openEditModal(this)">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            @endcan
                                            @can('pengaturan.delete')
                                                <form method="post" action="{{ url('/pengaturan/merk/delete/' . $item->id) }}"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus Merk?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </li>
                                @endforeach
                                @if (count($merk) === 0)
                                    <p class="h5">Belum ada Merk</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ====== DataTables Initialization ====== -->


        {{-- MODAL CREATE --}}
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-tambah-merk">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Tambah Merk
                        </h3>
                    </div>
                    <form method="post" action="{{ url('pengaturan/merk') }}">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Merk</label>
                                        <input type="text" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror" id="nama-merk"
                                            placeholder="nama merk" />
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
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal-edit-merk">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <h3 class="modal-title" id="exampleModalCenterTitle02">
                            Edit Merk
                        </h3>
                    </div>
                    <form action="{{ url('pengaturan/merk/update/:id') }} " id="form-edit-merk" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01" class="h5">Nama Merk</label>
                                        <input type="text" name="nama" class="form-control" id="edit-nama-merk"
                                            placeholder="nama merk" />
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
                    $('#modal-tambah-merk').modal('show');
                @endif

                // Delegasikan event keydown ke document, untuk #nama-merk
                $(document).on('keydown', '#nama-merk', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        $(this).closest('form').submit();
                    }
                });

                // Bersihkan form saat modal ditutup
                $('#modal-tambah-merk').on('hidden.bs.modal', function() {
                    $(this).find('.is-invalid').removeClass('is-invalid');
                    $(this).find('.text-danger').remove();
                    $(this).find('input').val('');
                });

                // Reset form saat modal dibuka
                $('#modal-tambah-merk').on('show.bs.modal', function() {
                    $(this).find('form')[0].reset();
                });
            });

            // Fungsi untuk modal edit
            function openEditModal(el) {
                const item = JSON.parse(el.getAttribute('data-item'));
                const editForm = document.getElementById('form-edit-merk')
                const inputName = document.getElementById('edit-nama-merk')
                inputName.value = item.nama
                editForm.action = editForm.action.replace(":id", item.id)
            }
        </script>
    @endpush
