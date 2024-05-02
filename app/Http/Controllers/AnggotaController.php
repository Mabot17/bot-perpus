<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\AnggotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil nilai pencarian dari permintaan HTTP
        $search = $request->input('search');

        // Mengambil data anggota dan mengurutkannya berdasarkan ID terakhir
        $data_anggota = AnggotaModel::whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->when($search, function ($query) use ($search) {
                return $query->where('anggota_kode', 'like', '%' . $search . '%')
                    ->orWhere('anggota_nama', 'like', '%' . $search . '%')
                    ->orWhere('anggota_kelamin', 'like', '%' . $search . '%')
                    ->orWhere('anggota_alamat', 'like', '%' . $search . '%')
                    ->orWhere('anggota_keterangan', 'like', '%' . $search . '%');
            })
            ->orderBy('anggota_id', 'desc')
            ->paginate(10);

        // Mengirimkan data anggota dan nilai pencarian ke view
        return view('pages.anggota.main_anggota', compact('data_anggota', 'search'));
    }


    public function formTambahAnggota(){
        return view('pages.anggota.form_tambah_anggota');
    }

    public function formUbahAnggota($anggota_id){
        $data_anggota = AnggotaModel::findOrFail($anggota_id);
        return view('pages.anggota.form_ubah_anggota', compact('data_anggota'));
    }

    public function prosesTambahData(Request $request)
    {
        // Buat entri baru tanpa validasi
        $anggota = new AnggotaModel();

        // Set nilai-niali properti berdasarkan input form
        $anggota->anggota_kode = $request->anggota_kode;
        $anggota->anggota_nama = $request->anggota_nama;
        $anggota->anggota_kelamin = $request->anggota_kelamin;
        $anggota->anggota_alamat = $request->anggota_alamat;
        $anggota->anggota_keterangan = $request->anggota_keterangan;

        // // Simpan gambar ke direktori public gambar
        // if ($request->hasFile('anggota_foto_path')) {
        //     // Ambil nama file gambar
        //     $image = $request->file('anggota_foto_path');
        //     $imageName = $image->getClientOriginalName();

        //     // Buat direktori jika belum ada
        //     $directory = public_path('uploads/anggota/'.$request->anggota_nbi);
        //     if (!file_exists($directory)) {
        //         mkdir($directory, 0777, true);
        //     }

        //     // Pindahkan gambar ke direktori yang baru dibuat
        //     $image->move($directory, $imageName);
        //     $anggota->anggota_foto_path = 'uploads/anggota/'.$request->anggota_nbi.'/'.$imageName; // Simpan path gambar ke database
        // }

        // Simpan data ke database
        $anggota->save();

        Session::flash('success_insert_anggota', 'Data Anggota Berhasil Ditambahkan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('anggota');
    }

    public function prosesUbahData(Request $request)
    {

        $updated_anggota = AnggotaModel::findOrFail($request->anggota_id);

        $updated_anggota->anggota_kode = $request->anggota_kode;
        $updated_anggota->anggota_nama = $request->anggota_nama;
        $updated_anggota->anggota_kelamin = $request->anggota_kelamin;
        $updated_anggota->anggota_alamat = $request->anggota_alamat;
        $updated_anggota->anggota_keterangan = $request->anggota_keterangan;

        // Simpan gambar ke direktori public gambar
        // if ($request->hasFile('anggota_foto_path')) {
        //     // Ambil nama file gambar
        //     $image = $request->file('anggota_foto_path');
        //     $imageName = $image->getClientOriginalName();

        //     // Buat direktori jika belum ada
        //     $directory = public_path('uploads/anggota/'.$request->anggota_nbi);
        //     if (!file_exists($directory)) {
        //         mkdir($directory, 0777, true);
        //     }

        //     // Pindahkan gambar ke direktori yang baru dibuat
        //     $image->move($directory, $imageName);
        //     $updated_anggota->anggota_foto_path = 'uploads/anggota/'.$request->anggota_nbi.'/'.$imageName; // Simpan path gambar ke database
        // }

        $updated_anggota->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_update_anggota', 'Data Anggota Berhasil Diubah');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('anggota');
    }

    public function prosesHapusData($anggota_id)
    {
        $anggota = AnggotaModel::findOrFail($anggota_id);
        $anggota->delete();

        Session::flash('delete_anggota', 'Data Anggota Berhasil Dihapus');
        return redirect()->route('anggota');
    }

    public function cetakDataPDF() {
        $data_anggota = AnggotaModel::select('anggota.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('anggota.anggota_id', 'desc')
            ->get();

        $filename = 'data-anggota-'.date("Ymd-His").'.pdf';

        $pdf = new Dompdf();
        $pdf->loadHTML(view('pages.anggota.form_cetak_pdf_anggota', compact('data_anggota'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream($filename);
    }

    public function cetakDataExcel()
    {
        // Query untuk mendapatkan data anggota
        $data_anggota = AnggotaModel::select('anggota.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('anggota.anggota_id', 'desc')
            ->get();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Kode');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Keterangan');

        // Data anggota
        $row = 2;
        $number = 1;
        foreach ($data_anggota as $anggota) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $anggota->anggota_nama);
            $sheet->setCellValue('C' . $row, $anggota->anggota_kode);
            $sheet->setCellValue('D' . $row, $anggota->anggota_jenis_kelamin);
            $sheet->setCellValue('E' . $row, $anggota->anggota_alamat);
            $sheet->setCellValue('F' . $row, $anggota->anggota_keterangan);
            $row++;
            $number++;
        }

        // Buat writer Xlsx
        $writer = new Xlsx($spreadsheet);

        // Simpan file sementara di penyimpanan sementara
        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFilePath);

        // Atur header respons untuk file Excel
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        // Ambil tanggal saat ini untuk nama file
        $filename = 'data-anggota-'.date("Ymd-His").'.xlsx';

        // Kembalikan respons untuk mendownload file Excel
        return Response::download($tempFilePath, $filename, $headers)->deleteFileAfterSend(true);
    }
}
