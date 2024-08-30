@extends('layout.admin')

@section('content')
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Edit Barang Keluar</title>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mt-5">
                    <div class="card-body">
                        <form method="POST" action="{{ route('brgkeluar.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="statuskirim" class="col-form-label">Status Kirim</label>
                                        <select name="statuskirim" id="statuskirim" class="form-control">
                                            <option value="Belum Dikirim" {{ old('statuskirim', $item->statuskirim) == 'Belum Dikirim' ? 'selected' : '' }}>Belum Dikirim</option>
                                            <option value="Sudah Dikirim" {{ old('statuskirim', $item->statuskirim) == 'Sudah Dikirim' ? 'selected' : '' }}>Sudah Dikirim</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group row">
                                        <label for="bukti" class="col-form-label">Bukti</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="bukti" class="form-control" placeholder="Masukan Bukti Kirim">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group row">
                                        <label for="updatekirim" class="col-form-label">Tanggal Update</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="updatekirim" class="form-control" placeholder="Masukan Update Tanggal">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit Update Status</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
