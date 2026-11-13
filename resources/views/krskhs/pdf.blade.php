@php
    $tanggalCetak = now('Asia/Jakarta');
    $tahunAwal = $tanggalCetak->month >= 8 ? $tanggalCetak->year : $tanggalCetak->year - 1;
    $totalSks = $krskhs->sum(fn ($entry) => (int) ($entry->jadwal?->matakuliah?->sks ?? 0));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KRS {{ $registrasi->nim }}</title>
    <style>
        @page { margin: 18mm; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1f2937; }
        .header { text-align: center; border-bottom: 2px solid #374151; padding-bottom: 12px; margin-bottom: 18px; }
        h1 { margin: 0 0 5px; font-size: 18px; }
        .subtitle { margin: 0; font-size: 11px; }
        .identity { margin-bottom: 18px; line-height: 1.8; }
        .identity strong { display: inline-block; width: 115px; }
        table { width: 100%; border-collapse: collapse; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        th { background: #374151; color: #fff; padding: 9px 7px; border: 1px solid #374151; }
        td { border: 1px solid #d1d5db; padding: 8px 7px; vertical-align: top; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        .center { text-align: center; }
        .nowrap { white-space: nowrap; }
        .footer { margin-top: 18px; font-size: 9px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KARTU RENCANA STUDI (KRS)</h1>
        <p class="subtitle">Tahun Akademik {{ $tahunAwal }}/{{ $tahunAwal + 1 }}</p>
    </div>
    <div class="identity">
        <strong>No. Registrasi</strong>: {{ $registrasi->noReg }}<br>
        <strong>NIM</strong>: {{ $registrasi->nim ?? '-' }}<br>
        <strong>Nama Mahasiswa</strong>: {{ $registrasi->mahasiswa?->nama ?? '-' }}
    </div>
    <table>
        <thead>
            <tr><th>No.</th><th>Hari</th><th>Waktu</th><th>Mata Kuliah</th><th>SKS</th><th>Grup</th><th>Dosen</th><th>Ruang</th></tr>
        </thead>
        <tbody>
            @forelse ($krskhs as $entry)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $entry->jadwal?->hari ?? '-' }}</td>
                    <td class="center nowrap">{{ $entry->jadwal?->waktu ?? '-' }}</td>
                    <td>{{ $entry->jadwal?->matakuliah?->namaMK ?? '-' }}</td>
                    <td class="center">{{ $entry->jadwal?->matakuliah?->sks ?? '-' }}</td>
                    <td class="center">{{ $entry->jadwal?->grup ?? '-' }}</td>
                    <td>{{ $entry->jadwal?->dosen?->namaDosen ?? '-' }}</td>
                    <td>{{ $entry->jadwal?->ruang ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="center">Belum ada jadwal yang dipilih.</td></tr>
            @endforelse
            <tr><td colspan="4"><strong>Total SKS</strong></td><td class="center"><strong>{{ $totalSks }}</strong></td><td colspan="3"></td></tr>
        </tbody>
    </table>
    <p class="footer">Dicetak pada {{ $tanggalCetak->format('d-m-Y H:i') }} WIB.</p>
</body>
</html>
