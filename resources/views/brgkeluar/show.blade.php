@extends('layout.admin')

@push('css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS for modal -->
    <style>
        /* CSS untuk Modal */
        .modal-table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .modal-table th, .modal-table td {
            border: 1px solid #6e6e6e;
            text-align: left;
            padding: 8px;
        }

        .modal-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Orderan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Orderan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @if (Auth::user()->hakakses('admin'))
            <div class="input-group">
                <div class="pt-4 mr-2">
                    <!-- Tombol untuk ekspor PDF untuk item pertama di halaman ini -->
                    @if($query->count() > 0)
                        <a href="{{ route('brgkeluar.invoicepdf', ['id' => $id]) }}" class="btn btn-warning">Export Invoice</a>
                        <a href="{{ route('brgkeluar.suratjalanpdf', ['id' => $id]) }}" class="btn btn-info">Export Surat Jalan</a>
                    @endif
                </div>
            </div>
            @endif
            <!-- Tabel -->
            <div class="mt-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="px-10 py-10">No</th>
                            <th class="px-10 py-10">Kode Barang</th>
                            <th class="px-10 py-10">Nama Barang</th>
                            <th class="px-10 py-10">Harga Barang</th>
                            <th class="px-10 py-10">Qty</th>
                            <th class="px-10 py-10">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($query as $item)
                            <tr>
                                <td class="px-10 py-10">{{ $no++ }}</td>
                                <td class="px-10 py-10">{{ $item->kodebarang }}</td>
                                <td class="px-10 py-10">{{ $item->namabarang }}</td>
                                <td class="px-6 py-6">Rp. {{number_format ($item->hargabarang) }}</td>
                                <td class="px-10 py-10">{{ $item->qty }}</td>
                                <td class="px-10 py-10">Rp. {{number_format ($item->hargabarang * $item->qty) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $query->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JavaScript Opsional -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery, Popper.js, dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@endpush
