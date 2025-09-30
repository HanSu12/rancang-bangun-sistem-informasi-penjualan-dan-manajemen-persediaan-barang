<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h4 class="m-0">Manajemen Barang</h4>
	<button class="btn btn-primary" id="btnAdd"><i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru</button>
</div>

<div class="card border-0 shadow-sm">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped align-middle" id="tblBarang">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Kategori</th>
						<th class="text-end">Harga Beli</th>
						<th class="text-end">Harga Jual</th>
						<th class="text-end">Stok</th>
						<th>Satuan</th>
						<th width="120">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($barang as $b): ?>
						<tr data-id="<?= $b['id'] ?>">
							<td><?= esc($b['kode_barang']) ?></td>
							<td><?= esc($b['nama_barang']) ?></td>
							<td data-kategori-id="<?= esc($b['id_kategori']) ?>"><?= esc($b['nama_kategori']) ?></td>
							<td class="text-end"><?= number_format($b['harga_beli'], 2, ',', '.') ?></td>
							<td class="text-end"><?= number_format($b['harga_jual'], 2, ',', '.') ?></td>
							<td class="text-end"><?= number_format($b['stok']) ?></td>
							<td><?= esc($b['satuan']) ?></td>
							<td>
								<button class="btn btn-sm btn-warning btnEdit"><i class="bi bi-pencil-square"></i></button>
								<button class="btn btn-sm btn-danger btnDelete"><i class="bi bi-trash"></i></button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="barangModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<form id="barangForm">
				<div class="modal-header">
					<h5 class="modal-title" id="barangModalLabel">Tambah Barang</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-md-4">
							<label class="form-label">Kode Barang</label>
							<input type="text" class="form-control" name="kode_barang" required>
						</div>
						<div class="col-md-8">
							<label class="form-label">Nama Barang</label>
							<input type="text" class="form-control" name="nama_barang" required>
						</div>
						<div class="col-md-6">
							<label class="form-label">Kategori</label>
							<select class="form-select" name="id_kategori" required>
								<option value="">-- Pilih --</option>
								<?php foreach ($kategori as $k): ?>
									<option value="<?= $k['id'] ?>"><?= esc($k['nama_kategori']) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-3">
							<label class="form-label">Harga Beli</label>
							<input type="number" step="0.01" class="form-control" name="harga_beli" required>
						</div>
						<div class="col-md-3">
							<label class="form-label">Harga Jual</label>
							<input type="number" step="0.01" class="form-control" name="harga_jual" required>
						</div>
						<div class="col-md-3">
							<label class="form-label">Stok</label>
							<input type="number" class="form-control" name="stok" value="0" required>
						</div>
						<div class="col-md-3">
							<label class="form-label">Satuan</label>
							<input type="text" class="form-control" name="satuan" value="pcs" required>
						</div>
					</div>
					<div class="alert alert-danger mt-3 d-none" id="formErrors"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
(function(){
	const modalEl = document.getElementById('barangModal');
	const modal = new bootstrap.Modal(modalEl);
	const form = document.getElementById('barangForm');
	const errorsBox = document.getElementById('formErrors');
	let currentMode = 'create';
	let currentId = null;

	function openCreate(){
		currentMode = 'create';
		currentId = null;
		document.getElementById('barangModalLabel').textContent = 'Tambah Barang';
		form.reset();
		errorsBox.classList.add('d-none');
		form.action = '<?= site_url('barang/create') ?>';
		modal.show();
	}

	function openEdit(row){
		currentMode = 'update';
		currentId = row.dataset.id;
		document.getElementById('barangModalLabel').textContent = 'Edit Barang';
		form.reset();
		errorsBox.classList.add('d-none');
		form.action = '<?= site_url('barang/update') ?>/' + currentId;

		const cells = row.children;
		form.kode_barang.value = cells[0].textContent.trim();
		form.nama_barang.value = cells[1].textContent.trim();
		form.id_kategori.value = cells[2].getAttribute('data-kategori-id');
		form.harga_beli.value = cells[3].textContent.replaceAll('.', '').replace(',', '.');
		form.harga_jual.value = cells[4].textContent.replaceAll('.', '').replace(',', '.');
		form.stok.value = cells[5].textContent.replaceAll('.', '');
		form.satuan.value = cells[6].textContent.trim();
		modal.show();
	}

	document.getElementById('btnAdd').addEventListener('click', openCreate);

	document.querySelectorAll('#tblBarang .btnEdit').forEach(btn=>{
		btn.addEventListener('click', function(){
			openEdit(this.closest('tr'));
		});
	});

	document.querySelectorAll('#tblBarang .btnDelete').forEach(btn=>{
		btn.addEventListener('click', async function(){
			const row = this.closest('tr');
			if(!confirm('Hapus data ini?')) return;
			const res = await fetch('<?= site_url('barang/delete') ?>/' + row.dataset.id, { method: 'POST' });
			if(res.ok){ row.remove(); }
		});
	});

	form.addEventListener('submit', async function(e){
		e.preventDefault();
		const fd = new FormData(form);
		const res = await fetch(form.action, { method: 'POST', body: fd });
		const json = await res.json();
		if(!res.ok || json.status !== 'ok'){
			errorsBox.classList.remove('d-none');
			errorsBox.innerHTML = Object.values(json.errors || {error:'Terjadi kesalahan'})
				.map(x=>`<div>${x}</div>`).join('');
			return;
		}

		// Update table
		const d = json.data;
		if(currentMode === 'create'){
			const tr = document.createElement('tr');
			tr.setAttribute('data-id', d.id);
			tr.innerHTML = `
				<td>${d.kode_barang}</td>
				<td>${d.nama_barang}</td>
				<td data-kategori-id="${d.id_kategori}">${d.nama_kategori}</td>
				<td class="text-end">${Number(d.harga_beli).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
				<td class="text-end">${Number(d.harga_jual).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
				<td class="text-end">${Number(d.stok).toLocaleString('id-ID')}</td>
				<td>${d.satuan}</td>
				<td>
					<button class="btn btn-sm btn-warning btnEdit"><i class="bi bi-pencil-square"></i></button>
					<button class="btn btn-sm btn-danger btnDelete"><i class="bi bi-trash"></i></button>
				</td>`;
			document.querySelector('#tblBarang tbody').prepend(tr);

			tr.querySelector('.btnEdit').addEventListener('click', function(){ openEdit(tr); });
			tr.querySelector('.btnDelete').addEventListener('click', async function(){
				if(!confirm('Hapus data ini?')) return;
				const res = await fetch('<?= site_url('barang/delete') ?>/' + tr.dataset.id, { method: 'POST' });
				if(res.ok){ tr.remove(); }
			});
		}else{
			const row = document.querySelector(`#tblBarang tbody tr[data-id="${currentId}"]`);
			const cells = row.children;
			cells[0].textContent = d.kode_barang;
			cells[1].textContent = d.nama_barang;
			cells[2].textContent = d.nama_kategori; cells[2].setAttribute('data-kategori-id', d.id_kategori);
			cells[3].textContent = Number(d.harga_beli).toLocaleString('id-ID', {minimumFractionDigits:2});
			cells[4].textContent = Number(d.harga_jual).toLocaleString('id-ID', {minimumFractionDigits:2});
			cells[5].textContent = Number(d.stok).toLocaleString('id-ID');
			cells[6].textContent = d.satuan;
		}

		modal.hide();
	});
})();
</script>
<?= $this->endSection() ?>
