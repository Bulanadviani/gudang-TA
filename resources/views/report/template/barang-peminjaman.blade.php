<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Barang</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #34495e;
            margin: 30px 40px;
            background-color: #fff;
        }

        h3 {
            text-align: center;
            color: #8e44ad;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 2px;
            border-bottom: 3px solid #8e44ad;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            word-wrap: break-word;
        }

        thead {
            background-color: #8e44ad;
            color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 14px;
            vertical-align: middle;
            text-align: left;
            font-size: 13px;
        }

        th {
            font-weight: 700;
            white-space: nowrap;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        td:nth-child(11), td:nth-child(12), td:nth-child(13) {
            white-space: nowrap;
        }

        td:nth-child(7), td:nth-child(9), td:nth-child(10) {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <h3>Laporan Barang Peminjaman</h3>
    <table>
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Kode Rak</th>
                <th>Serial Number</th>
                <th>Kode Material</th>
                <th>Merk</th>
                <th>Spesifikasi</th>
                <th>Kategori</th>
                <th>Keadaan</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Nomor Surat</th>
                <th>Tanggal BASTP</th>
                <th>Tanggal Selesai</th>
                <th>PIC</th>
                <th>Dibuat</th>
                <th>Diubah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamanData as $item)
                <tr>
                    <td class="col-id">{{ $loop->iteration }}</td> {{-- Nomor Urut --}}
                    <td>{{ $item->kode_rak ?? '-' }}</td>
                    <td>{{ $item->serial_number ?? '-' }}</td>
                    <td>{{ $item->kode_material ?? '-' }}</td>
                    <td>{{ $item->merk ?? '-' }}</td>
                    <td>{{ $item->spesifikasi ?? '-' }}</td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                    <td>{{ $item->keadaan ?? '-' }}</td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->nomor_surat ?? '-' }}</td>
                    <td>{{ $item->tanggal_bastp ? \Carbon\Carbon::parse($item->tanggal_bastp)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->pic ?? '-' }}</td>
                    <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') : '-' }}</td>
                    <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
