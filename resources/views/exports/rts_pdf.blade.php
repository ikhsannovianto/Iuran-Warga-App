<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen RT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Manajemen RT</h1>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama RT</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Ketua RT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rts as $key => $rt)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $rt->nama_rt }}</td>
                <td>{{ $rt->alamat }}</td>
                <td>{{ $rt->ketua_rt }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
