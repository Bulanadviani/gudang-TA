<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Keluar</title>
    <style>
        /* Body styling */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #2c3e50;
            margin: 30px 40px;
            background-color: #fff;
        }

        /* Title */
        h3 {
            text-align: center;
            color: #27ae60; /* Adjusted color for Keluar reports */
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 2px;
            border-bottom: 3px solid #27ae60;
            padding-bottom: 8px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Use fixed layout for better control over column widths */
            word-wrap: break-word;
            margin-top: 20px;
        }

        thead {
            background-color: #27ae60; /* Adjusted color for Keluar reports */
            color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px; /* Slightly reduced padding */
            vertical-align: top; /* Align content to the top */
            text-align: left;
            font-size: 12px; /* Slightly smaller font */
        }

        th {
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        /* Column specific widths and wrapping */
        .col-id { width: 5%; }
        .col-kode-rak { width: 7%; }
        .col-serial-number { width: 9%; }
        .col-kode-material { width: 8%; }
        .col-merk { width: 7%; }
        .col-kategori { width: 7%; }
        .col-keadaan { width: 7%; }
        .col-lokasi { width: 7%; }
        .col-status { width: 7%; }
        .col-spesifikasi { width: 10%; word-wrap: break-word; white-space: normal; }
        .col-keterangan { width: 10%; word-wrap: break-word; white-space: normal; }
        .col-tanggal-keluar { width: 8%; white-space: nowrap; }
        .col-bukti-pengeluaran { width: 8%; word-wrap: break-word; white-space: normal; }
        .col-created-at, .col-updated-at { width: 8%; white-space: nowrap; }

        /* Responsive adjustments for smaller screens if needed (though typically for print/PDF) */
        @media print {
            body {
                font-size: 11px;
                margin: 20px 30px;
            }
            th, td {
                padding: 5px 6px;
                font-size: 10px;
            }
            h3 {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <h3>Laporan Barang Keluar</h3>
    <table>
        <thead>
            <tr>
                <th class="col-id">ID Keluar</th>
                <th class="col-kode-rak">Kode Rak</th>
                <th class="col-serial-number">Serial Number</th>
                <th class="col-kode-material">Kode Material</th>
                <th class="col-merk">Merk</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-keadaan">Keadaan</th>
                <th class="col-lokasi">Lokasi</th>
                <th class="col-status">Status</th>
                <th class="col-spesifikasi">Spesifikasi</th>
                <th class="col-keterangan">Keterangan Barang</th>
                <th class="col-tanggal-keluar">Tanggal Keluar</th>
                <th class="col-created-at">Tanggal Dibuat</th>
                <th class="col-updated-at">Tanggal Diubah</th>
            </tr>
        </thead>
        <tbody>
            {{-- Pastikan variabel yang di-loop adalah $keluarData --}}
            @foreach($keluarData as $item)
                <tr>
                    <td class="col-id">{{ $loop->iteration }}</td> {{-- Nomor Urut --}}
                    <td class="col-kode-rak">{{ $item->barang->kode_rak }}</td>
                    <td class="col-serial-number">{{ $item->barang->serial_number }}</td>
                    <td class="col-kode-material">{{ $item->barang->kode_material }}</td>
                    <td class="col-merk">{{ $item->barang->merk['nama'] }}</td>
                    <td class="col-kategori">{{ $item->barang->kategori['nama'] }}</td>
                    <td class="col-keadaan">{{ $item->barang->keadaan['nama'] }}</td>
                    <td class="col-lokasi">{{ $item->barang->lokasi['nama'] }}</td>
                    <td class="col-status">{{ $item->barang->status['nama'] }}</td>
                    <td class="col-spesifikasi">{{ $item->barang->spesifikasi }}</td>
                    <td class="col-keterangan">{{ $item->barang->keterangan }}</td>
                    <td class="col-tanggal-keluar">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                    <td class="col-created-at">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                    <td class="col-updated-at">{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>