<?php
$current = service('uri')->getPath();
function is_active($path, $current) { return trim($current, '/') === trim($path, '/'); }
?>
<div class="d-flex align-items-center mb-4">
	<i class="bi bi-bag-check fs-3 me-2"></i>
	<h5 class="m-0">UMKM POS</h5>
</div>
<nav class="nav nav-pills flex-column gap-1">
	<a class="nav-link <?= is_active('', $current)?'active':'' ?>" href="<?= site_url('/') ?>">
		<i class="bi bi-speedometer2 me-2"></i> Dashboard
	</a>
	<a class="nav-link <?= is_active('barang', $current)?'active':'' ?>" href="<?= site_url('barang') ?>">
		<i class="bi bi-box-seam me-2"></i> Manajemen Barang
	</a>
	<a class="nav-link <?= is_active('kategori', $current)?'active':'' ?>" href="<?= site_url('kategori') ?>">
		<i class="bi bi-tags me-2"></i> Kategori
	</a>
	<a class="nav-link <?= is_active('supplier', $current)?'active':'' ?>" href="<?= site_url('supplier') ?>">
		<i class="bi bi-truck me-2"></i> Supplier
	</a>
	<a class="nav-link <?= is_active('users', $current)?'active':'' ?>" href="<?= site_url('users') ?>">
		<i class="bi bi-people me-2"></i> Pengguna
	</a>
	<a class="nav-link <?= is_active('penjualan', $current)?'active':'' ?>" href="#">
		<i class="bi bi-receipt me-2"></i> Penjualan
	</a>
	<a class="nav-link <?= is_active('laporan', $current)?'active':'' ?>" href="#">
		<i class="bi bi-graph-up-arrow me-2"></i> Laporan
	</a>
</nav>
