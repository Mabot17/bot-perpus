@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    <h3 class="border rounded p-2">Data Buku</h3>
    <div class="border rounded p-2">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a class="btn btn-success" type="button" href="{{ route('buku.proses_cetak_excel') }}">
                    <i data-feather="file-text"></i>
                    Export Excel
                </a>
                <a class="btn btn-danger" type="button" href="{{ route('buku.proses_cetak_pdf') }}">
                    <i data-feather="file-text"></i>
                    Export PDF
                </a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $buku->buku_kode }}</td>
                    <td>{{ $buku->buku_nama }}</td>
                    <td>{{ $buku->buku_status}}</td>
                    <td>{{ $buku->buku_keterangan }}</td>
                    <td>
                        <a href="{{ url('laporan/form_detail_laporan/'.$buku->buku_id) }}" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important"><i data-feather="eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                @if ($data_buku->previousPageUrl())
                    <li class="page-item"><a class="page-link" href="{{ $data_buku->previousPageUrl() }}">Previous</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @endif

                @foreach ($data_buku->getUrlRange(1, $data_buku->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $data_buku->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endforeach

                @if ($data_buku->nextPageUrl())
                    <li class="page-item"><a class="page-link" href="{{ $data_buku->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
