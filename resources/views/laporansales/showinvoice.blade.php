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
                        <h1 class="m-0">Daftar Data Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daftar Data Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
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
                            @if (Auth::user()->hakakses('helper') || Auth::user()->hakakses('kepgudang'))
                                <th class="px-10 py-10">Status Kirim</th>
                                <th class="px-10 py-10">Bukti Kirim</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($showinvoice as $index => $item)
                            <tr>
                                <td class="px-10 py-10">{{ $index + $showinvoice->firstItem() }}</td>
                                <td class="px-10 py-10">{{ $item->nopembelian }}</td>
                                <td class="px-10 py-10">{{ $item->noinvoice }}</td>
                                <td class="px-10 py-10">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                                <td class="px-10 py-10">{{ $item->masteruser->name }}</td>
                                <td class="px-10 py-10">{{ $item->mastertoko->namatoko }}</td>
                                @if (Auth::user()->hakakses('helper'))
                                <td class="px-6 py-2">
                                    @if ($item->statuskirim == '0')
                                        @if (Auth::user()->hakakses('helper'))
                                            <form action="{{ route('validasikirim', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="validasi" class="form-control" aria-label="Default select example">
                                                    <option value="" disabled selected>Keterangan :</option>
                                                    <option value="Dikirim" {{ old('validasi', $item->statuskirim) == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                    <option value="Belum_Dikirim" {{ old('validasi', $item->statuskirim) == 'Belum_Dikirim' ? 'selected' : '' }}>Belum Dikirim</option>
                                                </select>
                                                <button type="submit" class="btn btn-info mt-1">OK</button>
                                            </form>
                                        @else
                                            <span class="badge badge-warning">Tunggu Verifikasi</span>
                                        @endif
                                    @else
                                        <div class="text-center">
                                            <span class="{{ $item->statuskirim == 'Dikirim' ? 'badge badge-success' : 'badge badge-danger' }}">
                                                {{ $item->statuskirim }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $showinvoice->links() }}
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
