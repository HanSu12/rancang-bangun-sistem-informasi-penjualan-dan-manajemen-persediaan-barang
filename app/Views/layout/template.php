<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($title ?? 'UMKM POS') ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
	<style>
		body { background-color: #f6f8fb; }
		.wrapper { display: flex; min-height: 100vh; }
		.sidebar { width: 260px; background-color: #0d6efd; color: #fff; }
		.sidebar a { color: #cfe2ff; text-decoration: none; }
		.sidebar a.active, .sidebar a:hover { color: #fff; }
		.content { flex: 1; }
	</style>
</head>
<body>
	<div class="wrapper">
		<aside class="sidebar p-3">
			<?= view('layout/sidebar') ?>
		</aside>
		<div class="content d-flex flex-column">
			<header class="border-bottom bg-white">
				<?= view('layout/header') ?>
			</header>
			<main class="flex-grow-1 p-4">
				<?= $this->renderSection('content') ?>
			</main>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
