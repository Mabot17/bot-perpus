<!DOCTYPE html>
<html>
<head>
    <title>Data buku</title>
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
    <h1>Data buku</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $buku->buku_kode }}</td>
                    <td>{{ $buku->buku_nama }}</td>
                    <td>{{ $buku->buku_status }}</td>
                    <td>{{ $buku->buku_keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
