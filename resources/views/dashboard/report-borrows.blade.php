<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Laporan Peminjaman Buku</title>

	<style>
		body {
			font-family: 'Times New Roman', 'Times', 'serif';
			font-size: 12 px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th ,td {
			border: 1px solid #ddd;
			padding: 6px;
		}

		th {
			background: #f5f5f5;
		}
	</style>
</head>
<body>
	<h3>Laporan Peminjaman Buku</h3>

	<p>Rentang data: {{ Carbon\Carbon::parse($starting)->format('d-m-Y') ?? 'semua' }} sampai {{ Carbon\Carbon::parse($ending)->format('d-m-Y') ?? 'semua' }}</p>

	<table>
		<thead>
			<tr>
				<th>Nomor</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Judul Buku</th>
				<th>Status</th>
				<th>Tanggal Pinjam</th>
				<th>Tanggal Kembali</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($borrows as $i => $borrow)
				<tr>
					<th>{{ $i + 1 }}</th>
					<td>{{ $borrow->kode_pinjam }}</td>
					<td>{{ $borrow->user->nama }}</td>
					<td>{{ $borrow->book->judul }}</td>
					<td>{{ $borrow->status_pinjam }}</td>
					<td>{{ Carbon\Carbon::parse($borrow->tgl_pinjam)->format('d-m-Y') }}</td>
					<td>{{ Carbon\Carbon::parse($borrow->tgl_kembali)->format('d-m-Y') }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>