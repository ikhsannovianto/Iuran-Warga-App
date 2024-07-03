<!DOCTYPE html>
<html>
<head>
    <title>Daftar Warga</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0275D8; 
            color: #FFFFFF; 
            text-align: center; 
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1 class="title">Daftar Warga</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>RT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wargas as $warga)
                <tr>
                    <td>{{ $warga->nama }}</td>
                    <td>{{ $warga->alamat }}</td>
                    <td>{{ $warga->no_telp }}</td>
                    <td>{{ $warga->email }}</td>
                    <td>{{ $warga->rt ? $warga->rt->nama_rt : 'Tidak ada RT' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
