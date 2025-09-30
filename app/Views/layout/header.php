<?php $username = session()->get('nama_lengkap') ?: session()->get('username'); ?>
<nav class="navbar navbar-expand-lg navbar-light px-3">
	<div class="container-fluid">
		<span class="navbar-brand fw-semibold">Dashboard</span>
		<div class="d-flex align-items-center gap-3 ms-auto">
			<span class="text-muted small"><i class="bi bi-person-circle me-1"></i><?= esc($username ?: 'Tamu') ?></span>
			<a href="<?= site_url('logout') ?>" class="btn btn-outline-secondary btn-sm">
				<i class="bi bi-box-arrow-right me-1"></i> Keluar
			</a>
		</div>
	</div>
</nav>
