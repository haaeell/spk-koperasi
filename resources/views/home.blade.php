@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <!-- Card Jumlah Koperasi -->
        <div class="col-md-3">
            <div class="card shadow border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Koperasi</h5>
                    <h3 class="text-primary">{{ $totalKoperasi }}</h3>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Kriteria -->
        <div class="col-md-3">
            <div class="card shadow border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Kriteria</h5>
                    <h3 class="text-success">{{ $totalKriteria }}</h3>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Sub-Kriteria -->
        <div class="col-md-3">
            <div class="card shadow border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sub-Kriteria</h5>
                    <h3 class="text-warning">{{ $totalSubKriteria }}</h3>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Penilaian -->
        <div class="col-md-3">
            <div class="card shadow border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Penilaian</h5>
                    <h3 class="text-danger">{{ $totalPenilaian }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Peringkat Koperasi -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">Peringkat Koperasi Terakhir</h5>
                    <canvas id="rankingChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('rankingChart').getContext('2d');
            var rankingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($koperasiNames),
                    datasets: [{
                        label: 'Skor Akhir',
                        data: @json($koperasiScores),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
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
        });
    </script>
@endpush
