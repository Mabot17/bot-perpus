<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\BukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BukuController extends Controller
{
    public function index()
    {
        // Mengambil data buku dan mengurutkannya berdasarkan ID terakhir
        $data_buku = BukuModel::select('buku.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('buku.buku_id', 'desc')
            ->paginate(10);

        return view('pages.buku.main_buku', compact('data_buku'));
    }

    public function laporanBuku()
    {
        // Mengambil data buku dan mengurutkannya berdasarkan ID terakhir
        $data_buku = BukuModel::select('buku.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('buku.buku_id', 'desc')
            ->paginate(10);

        return view('pages.laporan.main_laporan', compact('data_buku'));
    }

    public function formDetailLaporan($buku_id){
        $data_buku = BukuModel::findOrFail($buku_id);
        return view('pages.laporan.form_detail_laporan', compact('data_buku'));
    }

    public function formTambahBuku(){
        return view('pages.buku.form_tambah_buku');
    }

    public function formUbahBuku($buku_id){
        $data_buku = BukuModel::findOrFail($buku_id);
        return view('pages.buku.form_ubah_buku', compact('data_buku'));
    }

    public function formDetailBuku($buku_id){
        $data_buku = BukuModel::findOrFail($buku_id);
        return view('pages.buku.form_detail_buku', compact('data_buku'));
    }

    public function prosesTambahData(Request $request)
    {
        // Buat entri baru tanpa validasi
        $buku = new BukuModel();

        // Set nilai-niali properti berdasarkan input form
        $buku->buku_kode = $request->buku_kode;
        $buku->buku_nama = $request->buku_nama;
        $buku->buku_status = $request->buku_status;
        $buku->buku_keterangan = $request->buku_keterangan;

        if ($request->hasFile('buku_dokumen_path')) {
            // Ambil file dokumen PDF
            $pdf = $request->file('buku_dokumen_path');
            $pdfName = $pdf->getClientOriginalName();

            // Buat direktori jika belum ada
            $directory = public_path('uploads/pdf/'.$request->buku_id);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Pindahkan file PDF ke direktori yang baru dibuat
            $pdf->move($directory, $pdfName);
            $buku->buku_dokumen_path = 'uploads/pdf/'.$request->buku_id.'/'.$pdfName; // Simpan path PDF ke database
        }

        // Simpan data ke database
        $buku->save();

        Session::flash('success_insert_buku', 'Data Buku Berhasil Ditambahkan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('buku');
    }

    public function prosesUbahData(Request $request)
    {

        $updated_buku = BukuModel::findOrFail($request->buku_id);

        $updated_buku->buku_kode = $request->buku_kode;
        $updated_buku->buku_nama = $request->buku_nama;
        $updated_buku->buku_status = $request->buku_status;
        $updated_buku->buku_keterangan = $request->buku_keterangan;

        if ($request->hasFile('buku_dokumen_path')) {
            // Ambil file dokumen PDF
            $pdf = $request->file('buku_dokumen_path');
            $pdfName = $pdf->getClientOriginalName();

            // Buat direktori jika belum ada
            $directory = public_path('uploads/pdf/'.$request->buku_id);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Pindahkan file PDF ke direktori yang baru dibuat
            $pdf->move($directory, $pdfName);
            $updated_buku->buku_dokumen_path = 'uploads/pdf/'.$request->buku_id.'/'.$pdfName; // Simpan path PDF ke database
        }

        $updated_buku->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_update_buku', 'Data Buku Berhasil Diubah');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('buku');
    }

    public function prosesHapusData($buku_id)
    {
        $buku = BukuModel::findOrFail($buku_id);
        $buku->delete();

        Session::flash('delete_buku', 'Data Buku Berhasil Dihapus');
        return redirect()->route('buku');
    }

    public function cetakDataPDF() {
        $data_buku = BukuModel::select('buku.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('buku.buku_id', 'desc')
            ->get();

        $filename = 'data-buku-'.date("Ymd-His").'.pdf';

        $pdf = new Dompdf();
        $pdf->loadHTML(view('pages.buku.form_cetak_pdf_buku', compact('data_buku'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream($filename);
    }

    public function cetakDataExcel()
    {
        // Query untuk mendapatkan data buku
        $data_buku = BukuModel::select('buku.*')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('buku.buku_id', 'desc')
            ->get();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Kode');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Keterangan');

        // Data buku
        $row = 2;
        $number = 1;
        foreach ($data_buku as $buku) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $buku->buku_nama);
            $sheet->setCellValue('C' . $row, $buku->buku_kode);
            $sheet->setCellValue('D' . $row, $buku->buku_status);
            $sheet->setCellValue('E' . $row, $buku->buku_keterangan);
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
        $filename = 'data-buku-'.date("Ymd-His").'.xlsx';

        // Kembalikan respons untuk mendownload file Excel
        return Response::download($tempFilePath, $filename, $headers)->deleteFileAfterSend(true);
    }
}
