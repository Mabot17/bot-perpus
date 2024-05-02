@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    @include('pages.buku.alert_buku')
    @include('pages.buku.form_hapus_buku')
    <h3 class="border rounded p-2">Data Buku</h3>
    <div class="border rounded p-2">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a type="button" href="{{ route('buku.tambah') }}" class="btn btn-primary"><i data-feather="plus-circle"></i> Tambah Data</a>
            </div>
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
                        <a href="{{ url('buku/form_detail_buku/'.$buku->buku_id) }}" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important"><i data-feather="eye"></i></a>
                        <a href="{{ url('buku/form_ubah_buku/'.$buku->buku_id) }}" class="btn btn-sm btn-warning mr-1" style="text-align: center!important"><i data-feather="edit"></i></a>
                        <a class="btn btn-sm btn-danger" style="text-align: center!important" onclick="konfirmasiHapusBuku('{{ $buku }}')">
                            <i data-feather="trash-2"></i>
                        </a>
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
    <script>
        function konfirmasiHapusBuku(buku) {
            let dataBuku = JSON.parse(buku);
            // Memasukkan data buku ke dalam modal body
            var modalBody = `
                <b>Anda yakin ingin menghapus data buku dengan:</b>
                <table class="ml-3">
                    <tr>
                        <td><b>Nama</b></td>
                        <td><b>: ${dataBuku.buku_nama}</b></td>
                    </tr>
                    <tr>
                        <td><b>Kode</b></td>
                        <td><b>: ${dataBuku.buku_kode}</b></td>
                    </tr>
                </table>
                <br>
                <p><b>Data yang dihapus tidak bisa dikembalikan!!</b></p>
            `;

            // Memasukkan isi modal body yang telah dibuat ke dalam elemen dengan id 'modal-body'
            $('#modal-body-hapus-buku').html(modalBody);

            $('#button-hapus-buku').attr('onclick', `window.location.href='/buku/proses_hapus_buku/${dataBuku.buku_id}'`);

            // Membuka modal
            $('#hapus-buku-modal').modal('show');
        }
    </script>
@endsection
