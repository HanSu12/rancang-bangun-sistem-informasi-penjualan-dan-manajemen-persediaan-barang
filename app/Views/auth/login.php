<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - UMKM</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body { background-color: #f8fafc; }
		.card { border: 0; box-shadow: 0 10px 25px rgba(0,0,0,.05); }
		.logo { font-weight: 700; letter-spacing: .5px; }
	</style>
</head>
<body>
	<div class="container d-flex align-items-center justify-content-center min-vh-100">
		<div class="row w-100 justify-content-center">
			<div class="col-12 col-sm-10 col-md-8 col-lg-5">
				<div class="text-center mb-4">
					<div class="logo h3 m-0">UMKM POS</div>
					<div class="text-muted">Sistem Informasi Penjualan & Persediaan</div>
				</div>
				<div class="card p-4">
					<?php if (session()->getFlashdata('error')): ?>
						<div class="alert alert-danger" role="alert">
							<?= esc(session()->getFlashdata('error')) ?>
						</div>
					<?php endif; ?>
					<form action="<?= site_url('login_process') ?>" method="post">
						<?= csrf_field() ?>
						<div class="mb-3">
							<label for="username" class="form-label">Username</label>
							<input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required autofocus>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">Masuk</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
