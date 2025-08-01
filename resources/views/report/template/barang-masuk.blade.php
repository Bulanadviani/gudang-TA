<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Masuk</title>
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
            color: #2980b9;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 2px;
            border-bottom: 3px solid #2980b9;
            padding-bottom: 8px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Use fixed layout for better control over column widths */
            word-wrap: break-word;
            margin-top: 20px; /* Add some space below the title */
        }

        thead {
            background-color: #2980b9;
            color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px; /* Slightly reduced padding for more content */
            vertical-align: top; /* Align content to the top */
            text-align: left;
            font-size: 12px; /* Slightly smaller font for more content */
        }

        th {
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden; /* Hide overflow if text is too long */
            text-overflow: ellipsis; /* Add ellipsis for overflowed text */
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr {
            page-break-inside: avoid; /* avoid breaking rows across pages */
        }

        /* Column specific widths and wrapping */
        .col-id { width: 5%; }
        .col-kode-rak { width: 8%; }
        .col-serial-number { width: 10%; }
        .col-merk { width: 8%; }
        .col-kategori { width: 8%; }
        .col-keadaan { width: 8%; }
        .col-lokasi { width: 8%; }
        .col-status { width: 8%; }
        .col-keterangan { width: 15%; word-wrap: break-word; white-space: normal; }
        .col-tanggal-masuk { width: 10%; white-space: nowrap; }
        .col-spesifikasi { width: 12%; word-wrap: break-word; white-space: normal; }
        .col-material { width: 8%; } /* Added for kode_material */

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
    <h3>Laporan Barang Masuk</h3>
    <table>
        <thead>
            <tr>
                <th class="col-id">ID Barang</th>
                <th class="col-kode-rak">Kode Rak</th>
                <th class="col-serial-number">Serial Number</th>
                <th class="col-material">Kode Material</th>
                <th class="col-merk">Merk</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-keadaan">Keadaan</th>
                <th class="col-lokasi">Lokasi</th>
                <th class="col-status">Status</th>
                <th class="col-spesifikasi">Spesifikasi</th>
                <th class="col-keterangan">Keterangan</th>
                <th class="col-tanggal-masuk">Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
                @foreach($masukData as $item)
                <tr>
                    <td class="col-id">{{ $loop->iteration }}</td> {{-- Nomor Urut --}}
                    <td class="col-kode-rak">{{ $item->kode_rak }}</td>
                    <td class="col-serial-number">{{ $item->serial_number }}</td>
                    <td class="col-material">{{ $item->kode_material }}</td>
                    <td class="col-merk">{{ $item->merk }}</td>
                    <td class="col-kategori">{{ $item->kategori }}</td>
                    <td class="col-keadaan">{{ $item->keadaan }}</td>
                    <td class="col-lokasi">{{ $item->lokasi }}</td>
                    <td class="col-status">{{ $item->status }}</td>
                    <td class="col-spesifikasi">{{ $item->spesifikasi }}</td>
                    <td class="col-keterangan">{{ $item->keterangan }}</td>
                    <td class="col-tanggal-masuk">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>