<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Times New Roman', serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #0275D8;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">Laporan Pembayaran</h1>

    <h2>Total Pendapatan</h2>
    <table>
        <thead>
            <tr>
                <th>Total Pendapatan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($data['totalPendapatan'], 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Pendapatan Per Bulan</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Pendapatan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pendapatanPerBulan'] as $item)
                <tr>
                    <td>{{ $item['bulan'] }}</td>
                    <td>{{ number_format($item['total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Pembayaran Per Metode</h2>
    <table>
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pembayaranPerMetode'] as $item)
                <tr>
                    <td>{{ $item['Metode Pembayaran'] }}</td>
                    <td>{{ number_format($item['Total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total Pembayaran Per RT</h2>
    <table>
        <thead>
            <tr>
                <th>Nama RT</th>
                <th>Total Pembayaran (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['totalPembayaranPerRT'] as $item)
                <tr>
                    <td>{{ $item['Nama RT'] }}</td>
                    <td>{{ number_format($item['Total Pembayaran'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
