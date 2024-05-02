@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    <h3 class="border rounded p-2">Tambah Data Buku</h3>
    <div class="border rounded p-2">
        <form method="POST" action="{{ route('buku.proses_tambah') }}" enctype="multipart/form-data">
            @csrf
            <table class="table" width="100%">
                <tr>
                    <td>
                        <div class="mb-3">
                            <label for="buku_kode" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="buku_kode" name="buku_kode">
                        </div>
                        <div class="mb-3">
                            <label for="buku_nama" class="form-label">Nama Buku</label>
                            <input type="text" class="form-control" id="buku_nama" name="buku_nama">
                        </div>
                        <div class="mb-3">
                            <label for="selectStatus">Status</label>
                            <select class="selectpicker form-control" data-style="py-0" id="selectStatus" value="" name="buku_status">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea2" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" name="buku_keterangan"></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary mr-3"><i data-feather="save"></i> Simpan</button>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">
                            <label for="buku_dokumen_path" class="form-label">Dokumen PDF</label>
                            <input type="file" class="form-control" id="buku_dokumen_path" name="buku_dokumen_path" onchange="previewPdf(this)">
                        </div>
                        <div class="mt-3 text-center" id="pdfPreview" style="display: none;">
                            <embed id="previewPdf" src="#" type="application/pdf" width="80%" height="400px">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        function previewPdf(input) {
            var file = input.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#pdfPreview').show();
                $('#previewPdf').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    </script>
@endsection
