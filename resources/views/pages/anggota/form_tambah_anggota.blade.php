@extends('layout.main_layout')

@section('konten_paw')
    <h3>&nbsp;</h3>
    <h3 class="border rounded p-2">Tambah Data Anggota</h3>
    <div class="border rounded p-2">
        <form method="POST" action="{{ route('anggota.proses_tambah') }}">
            @csrf
            <div class="mb-3">
                <label for="anggota_kode" class="form-label">Kode</label>
                <input type="text" class="form-control" id="anggota_kode" name="anggota_kode">
            </div>
            <div class="mb-3">
                <label for="anggota_nama" class="form-label">Nama Anggota</label>
                <input type="text" class="form-control" id="anggota_nama" name="anggota_nama">
            </div>
            <div class="mb-3">
                <label for="selectKelamin">Jenis Kelamin</label>
                <select class="selectpicker form-control" data-style="py-0" id="selectKelamin" value="" name="anggota_kelamin">
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="anggota_alamat"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea2" class="form-label">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" name="anggota_keterangan"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary mr-3"><i data-feather="save"></i> Simpan</button>
            </div>
        </form>
    </div>
@endsection
