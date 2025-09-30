<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h4 class="m-0">Manajemen Kategori</h4>
	<button class="btn btn-primary" id="btnAdd"><i class="bi bi-plus-lg me-1"></i> Tambah Kategori</button>
</div>
<div class="card border-0 shadow-sm">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped align-middle" id="tblKategori">
				<thead>
					<tr>
						<th>Nama Kategori</th>
						<th width="120">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $it): ?>
						<tr data-id="<?= $it['id'] ?>">
							<td><?= esc($it['nama_kategori']) ?></td>
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

<div class="modal fade" id="kategoriModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="kategoriForm">
				<div class="modal-header">
					<h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<label class="form-label">Nama Kategori</label>
					<input type="text" class="form-control" name="nama_kategori" required>
					<div class="alert alert-danger mt-3 d-none" id="formErrors"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
(function(){
	const modal = new bootstrap.Modal(document.getElementById('kategoriModal'));
	const form = document.getElementById('kategoriForm');
	const errorsBox = document.getElementById('formErrors');
	let mode = 'create', currentId = null;

	document.getElementById('btnAdd').addEventListener('click', ()=>{
		mode = 'create'; currentId = null;
		document.getElementById('kategoriModalLabel').textContent = 'Tambah Kategori';
		form.reset(); errorsBox.classList.add('d-none');
		form.action = '<?= site_url('kategori/create') ?>';
		modal.show();
	});

	document.querySelectorAll('#tblKategori .btnEdit').forEach(btn=>btn.addEventListener('click', function(){
		mode = 'update';
		const tr = this.closest('tr'); currentId = tr.dataset.id;
		document.getElementById('kategoriModalLabel').textContent = 'Edit Kategori';
		form.reset(); errorsBox.classList.add('d-none');
		form.action = '<?= site_url('kategori/update') ?>/' + currentId;
		form.nama_kategori.value = tr.children[0].textContent.trim();
		modal.show();
	}));

	document.querySelectorAll('#tblKategori .btnDelete').forEach(btn=>btn.addEventListener('click', async function(){
		const tr = this.closest('tr');
		if(!confirm('Hapus kategori ini?')) return;
		const res = await fetch('<?= site_url('kategori/delete') ?>/' + tr.dataset.id, { method: 'POST' });
		if(res.ok) tr.remove();
	}));

	form.addEventListener('submit', async function(e){
		e.preventDefault();
		const res = await fetch(form.action, { method: 'POST', body: new FormData(form) });
		const json = await res.json();
		if(!res.ok || json.status !== 'ok'){
			errorsBox.classList.remove('d-none');
			errorsBox.innerHTML = Object.values(json.errors || {error:'Terjadi kesalahan'})
				.map(x=>`<div>${x}</div>`).join('');
			return;
		}
		if(mode==='create'){
			const tr = document.createElement('tr');
			tr.dataset.id = json.data.id;
			tr.innerHTML = `
				<td>${json.data.nama_kategori}</td>
				<td>
					<button class="btn btn-sm btn-warning btnEdit"><i class="bi bi-pencil-square"></i></button>
					<button class="btn btn-sm btn-danger btnDelete"><i class="bi bi-trash"></i></button>
				</td>`;
			document.querySelector('#tblKategori tbody').prepend(tr);
			tr.querySelector('.btnEdit').addEventListener('click', function(){
				mode='update'; currentId = tr.dataset.id;
				document.getElementById('kategoriModalLabel').textContent='Edit Kategori';
				form.action='<?= site_url('kategori/update') ?>/' + currentId;
				form.nama_kategori.value = tr.children[0].textContent.trim();
				modal.show();
			});
			tr.querySelector('.btnDelete').addEventListener('click', async function(){
				if(!confirm('Hapus kategori ini?')) return;
				const res = await fetch('<?= site_url('kategori/delete') ?>/' + tr.dataset.id, { method:'POST' });
				if(res.ok) tr.remove();
			});
		}else{
			const row = document.querySelector(`#tblKategori tbody tr[data-id="${currentId}"]`);
			row.children[0].textContent = json.data.nama_kategori;
		}
		modal.hide();
	});
})();
</script>
<?= $this->endSection() ?>
