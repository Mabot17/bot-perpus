@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    <h3 class="border rounded p-2">Detail Data Laporan</h3>
    <div class="border rounded p-2">
        <table class="table" width="100%">
            <tr>
                <td>
                    <div class="mb-3">
                        <label for="buku_kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="buku_kode" name="buku_kode" value="{{$data_buku->buku_kode}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="buku_nama" class="form-label">Nama Buku</label>
                        <input type="text" class="form-control" id="buku_nama" name="buku_nama" value="{{$data_buku->buku_nama}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="selectStatus">Status</label>
                        <select class="selectpicker form-control" data-style="py-0" id="selectStatus" value="" name="buku_status" value="{{$data_buku->buku_status}}" readonly>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea2" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" name="buku_keterangan" readonly>{{$data_buku->buku_keterangan}}</textarea>
                    </div>
                </td>
                <td>
                    <div class="mt-3 text-center" id="pdfPreview" @if($data_buku->buku_dokumen_path) style="display: block;" @else style="display: none;" @endif>
                        <embed id="previewPdf" src="{{ asset($data_buku->buku_dokumen_path) }}" type="application/pdf" width="80%" height="400px">
                    </div>
                </td>
            </tr>
        </table>
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
