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

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
						<input class="form-control mb-3" type="text" name="daterange" value="2019-07-01 - 2019-07-31" required />
					<?php } ?>
				</div>
				<div class="col-6">
					<select class="form-control mb-3" name="cabang" id="" required>
						<option>- Cabang -</option>
						<?php foreach ($cabang as $row) { ?>
							<option <?= (isset($_GET['cabang'])) ? ($_GET['cabang'] == $row->id) ? "selected" : "" : ""  ?> value="<?= $row->id ?>"><?= $row->nama ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-6">
					<select class="form-control mb-3" name="item[]" id="multi-select" multiple="multiple" required>
						<option value="">- Item -</option>
						<?php foreach ($item as $row) { ?>
							<option <?= (isset($_GET['item'])) ? ($_GET['item'] == $row->id) ? "selected" : "" : "" ?> value="<?= $row->id ?>"><?= $row->nama ?></option>
						<?php } ?>

					</select>
				</div>
				<div class="col-6">
					<select class="form-control mb-3 item-gudang" name="gudang" id="" required>
						<option class="" value="">- Gudang -</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-sm mb-3 float-end">Search</button>
		</form>
		<?php if (isset($data)) {
			if (count($data) > 0) {
				for ($i = 0; $i < count($data); $i++) {
					if (isset($data[$i]['laporan'])) {
		?>
						<table class="table table-striped mb-4" style="font-size: 14px;">
							<thead class="table-primary">
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
								<tr>
									<td colspan="13">
										<span class="">
											Nama Item: <span class="fw-bold"><?= $data[$i]['nama_item'] ?></span>
										</span>
									</td>
								</tr>
								<tr>
									<td><?= date("d M Y", strtotime($data[$i]['laporan'][0]->tanggal)) ?></td>
									<td colspan="9" class="text-center">Saldo Awal</td>
									<td><?= $data[$i]['jumlah'] . " " . $data[$i]['laporan'][0]->item_satuan ?></td>
									<td>Rp <?= number_format($data[$i]['harga'], 0, ',', '.') ?></td>
									<td>Rp <?= number_format($data[$i]['saldo'], 0, ',', '.') ?></td>
								</tr>
								<?php
								$harga_awal = $data[$i]['harga'];
								$saldo_awal = $data[$i]['saldo'];
								$jumlah_awal = $data[$i]['jumlah'];

								$total_jumlah_masuk = 0;
								$total_harga_masuk = 0;
								$total_saldo_masuk = 0;
								$total_jumlah_keluar = 0;
								$total_harga_keluar = 0;
								$total_saldo_keluar = 0;

								$total_saldo_jumlah = 0;
								$total_saldo_harga = 0;
								$total_saldo = 0;
								foreach ($data[$i]['laporan'] as $key => $value) {
									$saldo_masuk = $value->jumlah_masuk * $value->harga_masuk;
									$saldo_keluar = $value->jumlah_keluar * $value->harga_keluar;

									if ($value->jumlah_masuk != null) {
										$data[$i]['jumlah'] = $data[$i]['jumlah'] + $value->jumlah_masuk;
										$data[$i]['saldo'] = $data[$i]['jumlah'] * $value->hpp;
										$bg_masuk = "table-success";
									} else {
										$bg_masuk = "";
									}

									if ($value->jumlah_keluar != null) {
										$data[$i]['jumlah'] = $data[$i]['jumlah'] - $value->jumlah_keluar;
										$data[$i]['saldo'] = $data[$i]['jumlah'] * $value->hpp;
										$bg_keluar = "table-danger";
									} else {
										$bg_keluar = "";
									}

									$total_jumlah_masuk = $total_jumlah_masuk + $value->jumlah_masuk;
									$total_harga_masuk = $total_harga_masuk + $value->harga_masuk;
									$total_saldo_masuk = $total_saldo_masuk + $saldo_masuk;

									$total_jumlah_keluar = $total_jumlah_keluar + $value->jumlah_keluar;
									$total_harga_keluar = $total_harga_keluar + $value->harga_keluar;
									$total_saldo_keluar = $total_saldo_keluar + $saldo_keluar;

									$total_saldo_jumlah = $total_saldo_jumlah + $data[$i]['jumlah'];
									$total_saldo_harga = $total_saldo_harga + $value->hpp;
									$total_saldo = $total_saldo + $data[$i]['saldo'];


								?>
									<tr>
										<td><?= date("d M Y", strtotime($value->tanggal)) ?></td>
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
											Rp
											<?= ($value->harga_keluar != null) ? number_format($value->harga_keluar, 0, ',', '.') : "-"  ?>
										</td>
										<td class="<?= $bg_keluar ?>">
											Rp <?= number_format($saldo_keluar, 0, ',', '.') ?>
										</td>

										<td><?= $data[$i]['jumlah'] . " " . $value->item_satuan ?></td>
										<td>Rp <?= number_format($value->hpp, 0, ',', '.') ?></td>
										<td>Rp <?= number_format($data[$i]['saldo'], 0, ',', '.') ?></td>
									</tr>
								<?php }
								$total_saldo_jumlah = $total_saldo_jumlah + $jumlah_awal;
								$total_saldo_harga = $total_saldo_harga + $harga_awal;
								$total_saldo = $total_saldo + $saldo_awal;
								?>
								<tr>
									<td colspan="4" class="text-center fw-bold">TOTAL</td>
									<td class="fw-bold"><?= $total_jumlah_masuk . " " . $value->item_satuan ?></td>
									<td class="fw-bold">Rp <?= number_format($total_harga_masuk, 0, ',', '.')  ?></td>
									<td class="fw-bold">Rp <?= number_format($total_saldo_masuk, 0, ',', '.') ?></td>
									<td class="fw-bold"><?= $total_jumlah_keluar . " " . $value->item_satuan ?></td>
									<td class="fw-bold">Rp <?= number_format($total_harga_keluar, 0, ',', '.') ?></td>
									<td class="fw-bold">Rp <?= number_format($total_saldo_keluar, 0, ',', '.') ?></td>
									<td class="fw-bold"><?= $total_saldo_jumlah . " " . $value->item_satuan  ?></td>
									<td class="fw-bold">Rp <?= number_format($total_saldo_harga, 0, ',', '.') ?></td>
									<td class="fw-bold">Rp <?= number_format($total_saldo, 0, ',', '.') ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					<?php } else {
					echo "<h3 class='text-center'>No data found</h3>";
				} ?>
				<?php } else {
				echo "<h3 class='text-center'>No data found</h3>";
			} ?>
							</tbody>
						</table>

	</div>
	<script type="text/javascript">
		<?php if(isset($_GET['item'])){ ?>
			$('#multi-select').val(<?= json_encode($_GET['item']) ?>).trigger('change');
		<?php } ?>
		$('#multi-select').select2({
			placeholder: {
				id: '-1', // the value of the option
				text: 'Select an option'
			}
		});

		$('#multi-select').on('select2:opening select2:closing', function(event) {
			var $searchfield = $(this).parent().find('.select2-search__field');
			$searchfield.prop('disabled', true);
		});

		$(function() {
			$('input[name="daterange"]').daterangepicker({
				locale: {
					format: 'YYYY-MM-DD'
				},
			});
		});

		<?php
		if (isset($_GET['cabang'])) { ?>
			var id_cabang = <?= isset($_GET['cabang']) ?>;
			$.ajax({
				type: "method",
				url: "<?= site_url('/welcome/get_gudang/') ?>" + id_cabang,
				data: "data",
				dataType: "json",
				success: function(response) {
					console.log(response);
					$(".item-gudang").html("");
					$.each(response, function(k, v) {
						/// do stuff
						console.log(v.nama_cabang);
						$(".item-gudang").append(new Option(v.nama_cabang, v.id));
					});
				}
			});
		<?php
		} ?>



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
						$(".item-gudang").append(new Option(v.nama_cabang, v.id));
					});
				}
			});
		});
	</script>
</body>

</html>