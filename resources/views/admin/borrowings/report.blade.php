<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sirkulasi Peminjaman Alat</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px 8px; text-align: left; font-size: 14px; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 12px; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
        .bg-pending { background-color: #fef08a; color: #854d0e; }
        .bg-approved { background-color: #bfdbfe; color: #1e40af; }
        .bg-returned { background-color: #bbf7d0; color: #166534; }
        .bg-rejected { background-color: #fecaca; color: #991b1b; }
        .print-btn { background: #4f46e5; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; font-weight: bold; margin-bottom: 20px; }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Cetak Laporan Ini</button>

    <div class="header">
        <h1>Laporan Sirkulasi Peminjaman Alat</h1>
        <p>Aplikasi Manajemen Aset & Peralatan | Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat (Kategori)</th>
                <th>Tgl Pinjam</th>
                <th>Target Kembali</th>
                <th>Kondisi Pengembalian</th>
                <th>Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $borrow)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $borrow->user->name }}</strong><br>
                    <small style="color:#666">{{ $borrow->user->email }}</small>
                </td>
                <td>{{ $borrow->equipment->name }}</td>
                <td>{{ $borrow->request_date->format('d/m/Y') }}</td>
                <td>{{ $borrow->expected_return_date->format('d/m/Y') }}</td>
                <td>{{ $borrow->actual_return_date ? $borrow->actual_return_date->format('d/m/Y') : '-' }}</td>
                <td>
                    <span class="status-badge 
                        @if($borrow->status == 'pending') bg-pending
                        @elseif($borrow->status == 'approved') bg-approved
                        @elseif($borrow->status == 'returned') bg-returned
                        @else bg-rejected @endif">
                        {{ strtoupper($borrow->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada sejarah sirkulasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Petugas Bertanggung Jawab</p>
        <br><br><br>
        <p><strong>( ________________________ )</strong></p>
    </div>

</body>
</html>
