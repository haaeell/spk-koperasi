@extends('layouts.app')
@section('title', 'Peringkat Koperasi')

@section('content')

    <h4 class="mt-4">Peringkat Koperasi</h4>
    <div class="table-responsive">
        <table id="peringkatTable" class="table table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Peringkat</th>
                    <th>Koperasi</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $peringkat = 1; @endphp
                @foreach ($peringkatKoperasi as $koperasi)
                    <tr class="{{ $peringkat == 1 ? 'table-success fw-bold' : '' }}">
                        <td>{{ $peringkat }}</td>
                        <td class="text-nowrap">{{ $koperasi->kode }}</td>
                        <td>{{ number_format($koperasi->nilai_akhir, 4) }}</td>
                        <td>
                            @if ($peringkat == 1)
                                <span class="badge bg-success">🏆 Koperasi Terbaik</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                    </tr>
                    @php $peringkat++; @endphp
                @endforeach
            </tbody>
        </table>
        <div class="text-end mt-4">
            <form action="{{ route('simpan-hasil') }}" method="POST">
                @csrf
                <input type="hidden" name="data_perhitungan" value="{{ json_encode($peringkatKoperasi) }}">
                <button type="submit" class="btn btn-primary mb-3">Simpan Perhitungan</button>
            </form>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            var table = $("#peringkatTable").DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start'f>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'B>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'l i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">",
                "buttons": [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-success btn-sm',
                        title: 'Data Peringkat Koperasi',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> Export PDF',
                        className: 'btn btn-danger btn-sm',
                        title: 'Data Peringkat Koperasi',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function(doc) {
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 12,
                                color: 'white',
                                fillColor: '#4a86e8', 
                                alignment: 'center'
                            };
                            doc.content[1].table.widths = ['20%', '40%', '20%',
                            '20%']; 
                            doc.styles.title = {
                                fontSize: 14,
                                bold: true,
                                alignment: 'center'
                            };
                        }
                    }
                ]
            });
        });
    </script>
@endpush
