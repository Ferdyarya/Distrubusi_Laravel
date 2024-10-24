@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Row for Daily Reports -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg">
                            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0"><b>Laporan Hari Ini</b></h3>
                                <span class="font-weight-bold">{{ $dateNow->format('d F Y') }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    @foreach ([['Sales', $jumlahsales, 'text-success'], ['Outlet Terdaftar', $outletterdaftar, 'text-info'], ['Barang', $jumlahbahan, 'text-info'], ['Supplier', $jumlahsupplier, 'text-danger'], ['Barang Masuk', $jumlahbarangmasuk, 'text-warning'], ['Orderan', $orderan, 'text-dark'], ['Barang Retur', $jumlahbaranretur, 'text-primary'], ['Jumlah Laporan Yang Diterima', $laporanharianjumlah, 'text-secondary']] as [$title, $value, $color])
                                        <div class="col-6 col-md-3 mb-4">
                                            <h4 class="{{ $color }}"><b>{{ $title }}</b></h4>
                                            <h3>{{ $value }}</h3>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graph for Orders -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h3 class="card-title"><b>Orderan dalam 5 Bulan Terakhir</b></h3>
                            </div>
                            <div class="card-body">
                                <canvas id="orderChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('orderChart').getContext('2d');
                    const orderChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [
                                '{{ now()->subMonths(1)->format('F Y') }}',
                                '{{ now()->subMonths(2)->format('F Y') }}',
                                '{{ now()->subMonths(3)->format('F Y') }}',
                                '{{ now()->subMonths(4)->format('F Y') }}',
                                '{{ now()->subMonths(5)->format('F Y') }}'
                            ], // Labels for the last 5 months
                            datasets: [{
                                label: 'Jumlah Orderan',
                                data: [{{ $orderMonth1 }}, {{ $orderMonth2 }}, {{ $orderMonth3 }},
                                    {{ $orderMonth4 }}, {{ $orderMonth5 }}
                                ], // Data for the last 5 months
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>

            </div>
        </section>

        <style>
            .card-header {
                background-color: #007bff;
                /* Adjust color to match your theme */
                color: white;
            }

            .info-box {
                transition: transform 0.3s;
            }

            .info-box:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .shadow-lg {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .transition {
                transition: all 0.3s ease;
            }
        </style>

        <!-- /.content -->
    </div>
@endsection
