<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .status { font-weight: bold; text-transform: uppercase; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN ABSENSI KARYAWAN</h2>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr>
                <td>{{ $att->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                <td>{{ $att->check_in }}</td>
                <td>{{ $att->check_out ?? '--:--' }}</td>
                <td class="status">{{ $att->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
