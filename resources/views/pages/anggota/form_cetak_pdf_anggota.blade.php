<!DOCTYPE html>
<html>
<head>
    <title>Data anggota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data anggota</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_anggota as $anggota)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $anggota->anggota_kode }}</td>
                    <td>{{ $anggota->anggota_nama }}</td>
                    <td>{{ $anggota->anggota_kelamin }}</td>
                    <td>{{ $anggota->anggota_alamat }}</td>
                    <td>{{ $anggota->anggota_keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
