@extends('layout.admin')

@section('content')

<!-- Required meta tags -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

<title>Pendaftaran Outlet</title>


<body>
    <h1 class="text-center mb-4">Tambah Data Pendaftaran Outlite</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('pendafoutlite.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="exampleInputEmail1" class="col-sm-3 col-form-label">Pilih Tanggal</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('tanggal') }}" type="date" name="tanggal"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                            placeholder="Pilih Tanggal">
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="id_sales" class="col-sm-3 col-form-label">Sales</label>
                                    <div class="col-sm-9">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text mb-0">{{ Auth::user()->name }}</p>
                                                <input type="hidden" value="{{ Auth::user()->id }}" name="id_sales">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="namatoko" class="col-sm-3 col-form-label">Masukan Nama Toko</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('namatoko') }}" type="text" name="namatoko" class="form-control"
                                            placeholder="Masukan Nama Toko">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pemiliktoko" class="col-sm-3 col-form-label">Masukan Nama Pemilik</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('pemiliktoko') }}" type="text" name="pemiliktoko"
                                            class="form-control" placeholder="Masukan Nama Pemilik">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 col-form-label">Masukan Alamat</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('alamat') }}" type="text" name="alamat" class="form-control"
                                            placeholder="Masukan Alamat">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="domisili" class="col-sm-3 col-form-label">Masukan Domisili</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('domisili') }}" type="text" name="domisili" class="form-control"
                                            placeholder="Masukan Domisili">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fotoktp" class="col-sm-3 col-form-label">Masukan Foto KTP</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="fotoktp" class="form-control"
                                            placeholder="Masukan Foto KTP">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fototoko" class="col-sm-3 col-form-label">Masukan Foto Toko</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="fototoko" class="form-control"
                                            placeholder="Masukan Foto Toko">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_telp" class="col-sm-3 col-form-label">Masukan Nomor Telepon</label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('no_telp') }}" type="number" name="no_telp" class="form-control"
                                            placeholder="Masukan Nomor Telepon">
                                    </div>
                                </div>
                            </div>

                            <!-- Action button -->
                            <div class="container">
                                <div class="row justify-content-end mb-4">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

























<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
@endsection
