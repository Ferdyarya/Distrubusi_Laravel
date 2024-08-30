@extends('layout.admin')

@section('content')


<!-- Required meta tags -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

<title>Data Barang Masuk</title>


<body>
    <h1 class="text-center mb-4">Edit Barang Masuk</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('laporanharian.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Tanggal</label>
                                <input value="{{ old('tanggal') }}" type="date" name="tanggal"
                                    class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                    placeholder="Pilih Tanggal">
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
                            <div class="form-group">
                                <label for="exampleInputPassword1">Area</label>
                                <input value="{{ $item->area }}" type="text" name="area"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Kode Barang"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Channel</label>
                                <select name="chanel" class="form-control" id="exampleInputPassword1" required>
                                    <option value="MT MODERN TRATE" {{ $item->chanel == 'MT MODERN TRATE' ? 'selected' : '' }}>MT MODERN TRATE</option>
                                    <option value="GENERAL TRATE" {{ $item->chanel == 'GENERAL TRATE' ? 'selected' : '' }}>GENERAL TRATE</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Call</label>
                                <input value="{{ $item->call }}" type="number" name="call"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Call Hari ini"
                                    required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputPassword1">EC</label>
                                <input value="{{ $item->ec }}" type="number" name="ec"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan EC Hari Ini"
                                    required>
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Akumulasi EC</label>
                                <input value="{{ $item->akumulasiec }}" type="number" name="akumulasiec"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Akumulasi EC"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Target Harian</label>
                                <input value="{{ $item->targetharian }}" type="number" name="targetharian"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Target Harian"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Akumulasi Penjualan</label>
                                <input value="{{ $item->aktualharian }}" type="number" name="aktualharian"
                                    class="form-control" id="exampleInputPassword1" placeholder="Masukan Aktual Harian"
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
