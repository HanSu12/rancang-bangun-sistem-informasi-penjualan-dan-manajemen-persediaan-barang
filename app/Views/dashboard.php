<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
	<div class="row g-3">
		<div class="col-12 col-md-6 col-xl-3">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<div class="text-muted small">Total Produk</div>
					<div class="h3 m-0 fw-semibold"><?= number_format($summary['totalProduk'] ?? 0) ?></div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-xl-3">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<div class="text-muted small">Transaksi Hari Ini</div>
					<div class="h3 m-0 fw-semibold"><?= number_format($summary['transaksiHariIni'] ?? 0) ?></div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-xl-3">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<div class="text-muted small">Penjualan Hari Ini</div>
					<div class="h3 m-0 fw-semibold">Rp <?= number_format($summary['penjualanHariIni'] ?? 0, 0, ',', '.') ?></div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-xl-3">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<div class="text-muted small">Placeholder</div>
					<div class="h3 m-0 fw-semibold"><?= number_format($summary['placeholderLainnya'] ?? 0) ?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-3 mt-1">
		<div class="col-12 col-lg-7">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<h5 class="card-title">Grafik Penjualan (Placeholder)</h5>
					<div class="text-muted">Grafik akan ditempatkan di sini.</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-5">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<h5 class="card-title">Stok Menipis</h5>
					<table class="table table-sm align-middle">
						<thead>
							<tr>
								<th>Barang</th>
								<th class="text-end">Stok</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td class="text-end">-</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
