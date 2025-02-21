@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-primary">
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et?</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-primary">
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum ea inventore delectus voluptatum
                        quaerat incidunt, ut temporibus dolore vero et?</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-10">
        <div class="col-md-12 mx-auto">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                    datasets: [{
                        label: 'Jumlah Pengguna',
                        data: [12, 19, 3, 5, 8, 15],
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
