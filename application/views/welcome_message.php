<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bootstrap 5 Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	<!-- Include Date Range Picker -->
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
</head>

<body>

	<div class="container-fluid p-5 bg-primary text-white text-center">
		<h1>Laporan</h1>
	</div>

	<div class="container mt-5">
		<form action="#" method="get">
			<div class="row">
				<div class="col-6">
					<?php if (isset($_GET['daterange'])) { ?>
						<input class="form-control mb-3" type="text" name="daterange" value="<?= $_GET['daterange'] ?>" required />
					<?php } else { ?>
						<input class="form-control mb-3" type="text" name="daterange" value="2019-01-01 - 2019-01-31" required />
					<?php } ?>
				</div>
				<div class="col-6">
					<select class="form-control mb-3" name="cabang" id="">

						<option>- Cabang -</option>
						<?php foreach ($cabang as $row) { ?>
							<option <?= (isset($_GET['cabang'])) ? ($_GET['cabang'] == $row->id) ? "selected" : "" : ""  ?> value="<?= $row->id ?>"><?= $row->nama ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-6">
					<select class="form-control mb-3" name="item" id="">
						<option value="">- Item -</option>
						<?php foreach ($item as $row) { ?>
							<option <?= (isset($_GET['item'])) ? ($_GET['item'] == $row->nama) ? "selected" : "" : ""  ?> value="<?= $row->nama ?>"><?= $row->nama ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-6">
					<select class="form-control mb-3 item-gudang" name="gudang" id="" required>
						<option class="" value="">- Gudang -</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-sm mb-3 float-right">Search</button>
		</form>
		<table class="table table-striped" style="font-size: 14px;">
			<thead class="">
				<tr>
					<th rowspan="2" class="align-middle">Tanggal</th>
					<th rowspan="2" class="align-middle">No Referensi</th>
					<th rowspan="2" class="align-middle">Keterangan</th>
					<th rowspan="2" class="align-middle">Petugas</th>
					<th colspan="3" class="text-center">Masuk</th>
					<th colspan="3" class="text-center">Keluar</th>
					<th colspan="3" class="text-center">Saldo</th>
				<tr>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Saldo</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Saldo</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Saldo</th>
				</tr>

				</tr>
			</thead>
			<tbody>
				<?php if ($laporan != null) { ?>
					<tr>
						<td><?= date("d M Y" , strtotime($laporan[0]->tanggal)) ?></td>
						<td colspan="3" class="text-center">Saldo Awal</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $jumlah . " " . $laporan[0]->item_satuan ?></td>
						<td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
						<td>Rp <?= number_format($saldo, 0, ',', '.') ?></td>
					</tr>
					<?php foreach ($laporan as $key => $value) {
						$saldo_masuk = $value->jumlah_masuk * $value->harga_masuk;
						$saldo_keluar = $value->jumlah_keluar * $value->harga_keluar;

						if ($value->jumlah_masuk != null) {
							$jumlah = $jumlah + $value->jumlah_masuk;
							$saldo = $jumlah * $value->hpp;
							$bg_masuk = "table-success";
						} else {
							$bg_masuk = "";
						}

						if ($value->jumlah_keluar != null) {
							$jumlah = $jumlah - $value->jumlah_keluar;
							$saldo = $jumlah * $value->hpp;
							$bg_keluar = "table-danger";
						} else {
							$bg_keluar = "";
						}

					?>
						<tr>
							<td><?= date("d M Y" , strtotime($value->tanggal)) ?></td>
							<td><?= $value->kode ?></td>
							<td><?= $value->catatan ?></td>
							<td><?= $value->petugas ?></td>

							<td class="<?= $bg_masuk  ?>">
								<?= ($value->jumlah_masuk != null) ? $value->jumlah_masuk . " " . $value->item_satuan : "-" ?>
							</td>
							<td class="<?= $bg_masuk  ?>">
								Rp <?= ($value->harga_masuk != null) ? number_format($value->harga_masuk, 0, ',', '.') : "-" ?>
							</td>
							<td class="<?= $bg_masuk  ?>">
								Rp <?= number_format($saldo_masuk, 0, ',', '.')  ?>
							</td>

							<td class="<?= $bg_keluar  ?>">
								<?= ($value->jumlah_keluar != null) ? $value->jumlah_keluar . " " . $value->item_satuan : "-"  ?>
							</td>
							<td class="<?= $bg_keluar  ?>">
								Rp <?= ($value->harga_keluar != null) ? number_format($value->harga_keluar, 0, ',', '.') : "-"  ?>
							</td class="<?= $bg_keluar  ?>">
							<td class="<?= $bg_keluar ?>">
								Rp <?= number_format($saldo_keluar, 0, ',', '.') ?>
							</td>

							<td><?= $jumlah . " " . $value->item_satuan ?></td>
							<td>Rp <?= number_format($value->hpp, 0, ',', '.') ?></td>
							<td>Rp <?= number_format($saldo, 0, ',', '.') ?></td>
						</tr>
					<?php } ?>
				<?php } else {
					echo "<h3 class='text-center'>No data found</h3>";
				} ?>
			</tbody>
		</table>

	</div>
	<script type="text/javascript">
		$(function() {
			$('input[name="daterange"]').daterangepicker({
				locale: {
					format: 'YYYY-MM-DD'
				},
			});
		});


		$("[name='cabang']").on('click', function() {
			$.ajax({
				type: "method",
				url: "<?= site_url('/welcome/get_gudang/') ?>" + this.value,
				data: "data",
				dataType: "json",
				success: function(response) {
					console.log(response);
					$(".item-gudang").html("");
					$.each(response, function(k, v) {
						/// do stuff
						console.log(v.nama_cabang);
						$(".item-gudang").append(new Option(v.nama_cabang, v.nama_cabang));
					});
				}
			});
		});
	</script>
</body>

</html>