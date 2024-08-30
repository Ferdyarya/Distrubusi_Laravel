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

    <title>Barang Masuk</title>

    <body>
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card mt-5">
                        <div class="card-body">
                            <form method="POST" action="{{ route('brgkeluar.store') }}" enctype="multipart/form-data">
                                @csrf
                                {{-- <h1 class="text-center mb-4">Tambah Data Barang Masuk</h1> --}}
                                <div class="row ">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6 mb-3">
                                        <!-- No Pembelian -->
                                        <div class="form-group">
                                            <label for="id_pegawai" class="col-form-label">No Pembelian</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <input class="card-text mb-0" id="nopembelian" name="nopembelian" readonly value="{{ $newPurchaseNumber }}"></input>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label">Tanggal</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <input value="{{ old('tanggal') }}" type="date" name="tanggal"
                                                        class="form-control" id="tanggal" name="tanggal" placeholder="Pilih Tanggal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="id_pegawai" class="col-form-label">Sales</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="card-text mb-0">{{ Auth::user()->name }}</p>
                                                    <input class="card-text mb-0" type="hidden" value="{{ Auth::user()->id }}" id="id_sales" name="id_sales" readonly ></input>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Customer -->
                                        <div class="form-group">
                                            <label for="id_toko" class="col-form-label">Customer</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <select name="id_toko" class="form-select" id="id_toko">
                                                        <option value="" disabled selected>Pilih Customer</option>
                                                        @foreach ($pendafoutlite as $item)
                                                            <option value="{{ $item->id }}">{{ $item->namatoko }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action buttons -->
                                <div class="d-flex justify-content-between mb-4">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">Tambah Barang</button>
                                    <div>
                                        <a href="{{ route('brgkeluar.index') }}" class="btn btn-danger">Kembali</a>
                                        {{-- <button type="submit" class="btn btn-success">Simpan</button> --}}
                                    </div>
                                </div>

                                <!-- Barang Table -->
                                <table class="table table-bordered mt-3" id="selectedBarangTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectedBarangs">

                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="savePembelianBtn">Simpan Pembelian</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel">Pilih Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchBarang" placeholder="Cari barang..." class="form-control mb-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="barangTable">
                            <!-- Data akan diisi dengan JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="selectBarangBtn">Pilih Barang</button>
                </div>
            </div>
        </div>
    </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>


        <script>
            $(document).ready(function() {
                $('#id_toko').select2({
                    theme: "bootstrap-5",
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                        'style',
                    placeholder: $(this).data('placeholder'),
                });
            });
        </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/dashboard/barang')
        .then(response => {
            const barangData = response.data;
            const tableBody = document.getElementById('barangTable');
            barangData.forEach(barang => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${barang.id}</td>
                    <td>${barang.kodebarang}</td>
                    <td>${barang.namabarang}</td>
                    <td>${barang.hargabarang}</td>
                    <td><input type="checkbox" class="form-check-input barang-checkbox ml-3" value="${barang.id}" data-nama-barang="${barang.namabarang}" data-kode-barang="${barang.kodebarang}" data-harga-barang="${barang.hargabarang}"></td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error(error);
        });
        document.getElementById('searchBarang').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('#barangTable tr').forEach(row => {
                    const kodebarang = row.children[0].innerText.toLowerCase();
                    const namabarang = row.children[1].innerText.toLowerCase();
                    const hargabarang = row.children[2].innerText.toLowerCase();
                    row.style.display = kodebarang.includes(searchTerm) || namabarang.includes(
                        searchTerm) || hargabarang.includes(searchTerm) ? '' : 'none';
                });
            });

    document.getElementById('selectBarangBtn').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.barang-checkbox:checked');
        const selectedBarangContainer = document.getElementById('selectedBarangs');

        checkboxes.forEach(checkbox => {
            const barangId = checkbox.value;
            const kodeBarang = checkbox.getAttribute('data-kode-barang');
            const namaBarang = checkbox.getAttribute('data-nama-barang');
            const hargaBarang = checkbox.getAttribute('data-harga-barang');

            const row = document.createElement('tr');
            row.innerHTML = `
                <th scope="row">${barangId}</th>
                <td>${kodeBarang}</td>
                <td>${namaBarang}</td>
                <td>${hargaBarang}</td>
                <td><input type="number" class="form-control" value="0" min="0" step="0.01" placeholder="QTY" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"></td>
                <td><button class="btn btn-danger btn-sm remove-barang-btn">Hapus</button></td>
            `;

            selectedBarangContainer.appendChild(row);

            row.querySelector('.remove-barang-btn').addEventListener('click', function() {
                row.remove();
            });
        });
    });
    document.getElementById('savePembelianBtn').addEventListener('click', function() {
        const nopembelian = document.getElementById('nopembelian').value;
        const tanggal = document.getElementById('tanggal').value;
        const id_sales = document.getElementById('id_sales').value;
        const id_toko = document.getElementById('id_toko').value;
        const selectedBarangs = [];
        document.querySelectorAll('#selectedBarangs tr').forEach(row => {
            selectedBarangs.push({
                id_barang: row.children[0].innerText,
                qty: row.children[4].querySelector('input').value
            });
        });

        axios.post('{{ route("brgkeluar.store") }}', {
            nopembelian: nopembelian,
            tanggal: tanggal,
            id_sales: id_sales,
            id_toko: id_toko,
            selectedBarangs: selectedBarangs
        })
        .then(response => {
                Swal.fire({
                    title: 'Success!',
                    text: response.data.message || 'Data Berhasil Disubmit.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Redirect after closing the alert
                    window.location.href = '{{ route("brgkeluar.index") }}';
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Ada Error Tolong Dicek Kembali Datanya atau Codingannya',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    });
});
</script>


    </body>
@endsection
