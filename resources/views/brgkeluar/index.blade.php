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
            background-color: #4c7b25;
        }
        </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Header Konten (Header halaman) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Orderan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Orderan</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="container">
            <!-- Pencarian dan Tombol Tambah Data -->
            <div class="row g-3 align-items-center mb-4">
                <div class="col-auto">
                    <form action="brgkeluar" method="GET">
                        <input type="text" id="search" name="search" class="form-control" placeholder="Cari">
                    </form>
                </div>
                @if (Auth::user()->hakakses('sales')||Auth::user()->hakakses('admin'))
                <div class="col-auto">
                    <a href="{{ route('brgkeluar.create') }}" class="btn btn-success">Tambah Data</a>
                </div>
                @endif
            </div>

            <!-- Tabel -->
            <div>
                <table class="table table-hover px-lg-4">
                    <thead>
                        <tr>
                            <th class="px-10 py-10">No</th>
                            <th class="px-10 py-10">No Pembelian</th>
                            <th class="px-10 py-10">No Invoice</th>
                            <th class="px-10 py-10">Tanggal</th>
                            <th class="px-10 py-10">Sales</th>
                            <th class="px-10 py-10">Toko Pemesan</th>
                            @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('helper')|| Auth::user()->hakakses('supervisor'))
                            <th class="px-10 py-10">Tanggal Kirim</th>
                            <th class="px-10 py-10">Status Kirim</th>
                            <th class="px-10 py-10">Bukti Kirim</th>
                            <th class="px-10 py-10">Total Harga</th>
                            @endif
                            @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('helper'))
                            <th class="px-10 py-10">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($brgkeluar as $index => $item)
                            <tr>
                                <td class="px-10 py-10">{{ $index + $brgkeluar->firstItem() }}</td>
                                <td class="px-10 py-10">{{ $item->nopembelian }}</td>
                                <td class="px-10 py-10">{{ $item->noinvoice }}</td>
                                <td class="px-10 py-10">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                                <td class="px-10 py-10">{{ $item->masteruser->name }}</td>
                                <td class="px-10 py-10">{{ $item->mastertoko->namatoko }}</td>
                                <td class="px-10 py-10">{{ $item->updatekirim }}</td>
                                <td class="px-10 py-10">{{ $item->statuskirim }}</td>
                                <td class="px-10 py-10">
                                    <img src="{{ asset('bukti/'.$item->bukti) }}" alt="" style="width: 80px;">
                                </td>
                                <td class="px-10 py-10">Rp. {{number_format ($item->total_harga) }}</td>

                                <td>
                                    <div class="btn-group">
                                        @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin'))
                                        <form action="{{ route('brgkeluar.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-block">Hapus</button>
                                        </form>
                                        <form action="{{ route('brgkeluar.show', $item->id) }}" class="ml-2">
                                            <button type="submit" class="btn btn-info btn-block">Detail</button>
                                        </form>
                                        @endif
                                        @if (Auth::user()->hakakses('helper'))
                                        <form action="{{ route('brgkeluar.edit', $item->id) }}" class="ml-2">
                                            <button type="submit" class="btn btn-warning btn-block">Update</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $brgkeluar->links() }}
            </div>
        </div>
    </div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="modal-table">
                    <tbody>
                        <tr>
                            <th>No Pembelian</th>
                            <th>Toko Pemesan</th>
                            <th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Harga Barang</th>
                            <th>Kuantitas</th>
                            <th>Total Harga Barang</th>
                        </tr>
                        <tr>
                            <td id="modalNoPembelian"></td>
                            <td id="modalTokoPemesan"></td>
                            <td id="modalKodeBarang"></td>
                            <td id="modalNamaBarang"></td>
                            <td id="modalHargaBarang"></td>
                            <td id="modalQty"></td>
                            <td id="modalTotalHargaBarang"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
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
    <script>
        $('#detailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this);

            modal.find('#modalNoPembelian').text(button.data('nopembelian'));
            modal.find('#modalTokoPemesan').text(button.data('tokopemesan'));
            modal.find('#modalKodeBarang').text(button.data('kodebarang'));
            modal.find('#modalNamaBarang').text(button.data('namabarang'));
            modal.find('#modalHargaBarang').text(button.data('hargabarang'));
            modal.find('#modalQty').text(button.data('qty'));
            modal.find('#modalTotalHargaBarang').text(button.data('totalhargabarang'));
        });
    </script>
@endpush
