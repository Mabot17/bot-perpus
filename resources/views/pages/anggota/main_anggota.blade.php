@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    @include('pages.anggota.alert_anggota')
    @include('pages.anggota.form_detail_anggota')
    @include('pages.anggota.form_hapus_anggota')
    <h3 class="border rounded p-2">Data Anggota</h3>
    <div class="border rounded p-2">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a type="button" href="{{ route('anggota.tambah') }}" class="btn btn-primary"><i data-feather="plus-circle"></i> Tambah Data</a>
            </div>
            <div class="d-flex align-items-center">
                <form action="{{ route('anggota') }}" method="GET" class="mb-0 mr-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari...">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </form>
                <div class="m-3">
                    <a class="btn btn-warning" type="button" href="{{ route('anggota') }}">
                        <i data-feather="refresh-cw"></i>
                        Refresh
                    </a>
                </div>
                <div class="ml-3">
                    <a class="btn btn-success" type="button" href="{{ route('anggota.proses_cetak_excel') }}">
                        <i data-feather="file-text"></i>
                        Export Excel
                    </a>
                    <a class="btn btn-danger" type="button" href="{{ route('anggota.proses_cetak_pdf') }}">
                        <i data-feather="file-text"></i>
                        Export PDF
                    </a>
                </div>
            </div>
        </div>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Keterangan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_anggota as $anggota)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $anggota->anggota_kode }}</td>
                    <td>{{ $anggota->anggota_nama }}</td>
                    <td>{{ $anggota->anggota_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $anggota->anggota_alamat }}</td>
                    <td>{{ $anggota->anggota_keterangan }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important" onclick="detailAnggota('{{ $anggota}}')"><i data-feather="eye"></i></a>
                        <a href="{{ url('anggota/form_ubah_anggota/'.$anggota->anggota_id) }}" class="btn btn-sm btn-warning mr-1" style="text-align: center!important"><i data-feather="edit"></i></a>
                        <a class="btn btn-sm btn-danger" style="text-align: center!important" onclick="konfirmasiHapusAnggota('{{ $anggota }}')">
                            <i data-feather="trash-2"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                @if ($data_anggota->previousPageUrl())
                    <li class="page-item"><a class="page-link" href="{{ $data_anggota->previousPageUrl() }}">Previous</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @endif

                @foreach ($data_anggota->getUrlRange(1, $data_anggota->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $data_anggota->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endforeach

                @if ($data_anggota->nextPageUrl())
                    <li class="page-item"><a class="page-link" href="{{ $data_anggota->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
    <script>
        function konfirmasiHapusAnggota(anggota) {
            let dataAnggota = JSON.parse(anggota);
            // Memasukkan data anggota ke dalam modal body
            var modalBody = `
                <b>Anda yakin ingin menghapus data anggota dengan:</b>
                <table class="ml-3">
                    <tr>
                        <td><b>Nama</b></td>
                        <td><b>: ${dataAnggota.anggota_nama}</b></td>
                    </tr>
                    <tr>
                        <td><b>Kode</b></td>
                        <td><b>: ${dataAnggota.anggota_kode}</b></td>
                    </tr>
                </table>
                <br>
                <p><b>Data yang dihapus tidak bisa dikembalikan!!</b></p>
            `;

            // Memasukkan isi modal body yang telah dibuat ke dalam elemen dengan id 'modal-body'
            $('#modal-body-hapus-anggota').html(modalBody);

            $('#button-hapus-anggota').attr('onclick', `window.location.href='/anggota/proses_hapus_anggota/${dataAnggota.anggota_id}'`);

            // Membuka modal
            $('#hapus-anggota-modal').modal('show');
        }

        function detailAnggota(anggota) {
            let dataAnggota = JSON.parse(anggota);

            // Mengatur nilai dari elemen-elemen teks
            // if (dataAnggota.anggota_foto_path != null) {
            //     document.querySelector('.anggota-detail-profile-pic').src = "../" + dataAnggota.anggota_foto_path;
            // }else{
            //     document.querySelector('.anggota-detail-profile-pic').src = "../images/user/default-profile.jpg";
            // }
            $('#txtKode').val(dataAnggota.anggota_kode);
            $('#txtNama').val(dataAnggota.anggota_nama);
            if (dataAnggota.anggota_jenis_kelamin == 'L') {
                $('#txtKelamin').val('Laki-laki');
            }else{
                $('#txtKelamin').val('Perempuan');
            }
            $('#txtAlamat').text(dataAnggota.anggota_alamat);
            $('#txtKeterangan').text(dataAnggota.anggota_keterangan);

            // Membuka modal
            $('#detail-anggota-modal').modal('show');
        }
    </script>
@endsection
