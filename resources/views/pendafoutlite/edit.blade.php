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
    <h1 class="text-center mb-4">Edit Pendaftaran Outlet</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('pendafoutlite.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal</label>
                                <input value="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}" type="date" name="npwp" class="form-control"
                                    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Tanggal"
                                    required>
                            </div>
                            {{-- <div class="form-group row align-items-center">
                                <label for="id_sales" class="col-sm-3 col-form-label">Sales</label>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text mb-0">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="exampleInputPassword1">Kode Toko</label>
                                <input value="{{ $item->kodetoko }}" type="text" name="kodetoko"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Kode Toko"
                                    required>
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nama Toko</label>
                                <input value="{{ $item->namatoko }}" type="text" name="namatoko"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Nama Toko"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Pemilik Toko</label>
                                <input value="{{ $item->pemiliktoko }}" type="text" name="pemiliktoko"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Nama Pemilik"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <input value="{{ $item->alamat }}" type="text" name="alamat"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Alamat"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Domisili</label>
                                <input value="{{ $item->domisili }}" type="text" name="domisili"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan domisili"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">No Telepon</label>
                                <input value="{{ $item->no_telp }}" type="text" name="domisili"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan domisili"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
