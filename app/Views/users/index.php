<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h4 class="m-0">Manajemen Pengguna</h4>
	<button class="btn btn-primary" id="btnAdd"><i class="bi bi-plus-lg me-1"></i> Tambah Pengguna</button>
</div>
<div class="card border-0 shadow-sm">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped align-middle" id="tblUsers">
				<thead>
					<tr>
						<th>Nama Lengkap</th>
						<th>Username</th>
						<th>Level</th>
						<th width="120">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $u): ?>
						<tr data-id="<?= $u['id'] ?>">
							<td><?= esc($u['nama_lengkap']) ?></td>
							<td><?= esc($u['username']) ?></td>
							<td><?= esc($u['level']) ?></td>
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

<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<form id="userForm">
				<div class="modal-header">
					<h5 class="modal-title" id="userModalLabel">Tambah Pengguna</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-md-6">
							<label class="form-label">Nama Lengkap</label>
							<input type="text" class="form-control" name="nama_lengkap" required>
						</div>
						<div class="col-md-3">
							<label class="form-label">Username</label>
							<input type="text" class="form-control" name="username" required>
						</div>
						<div class="col-md-3">
							<label class="form-label">Level</label>
							<select class="form-select" name="level" required>
								<option value="admin">admin</option>
								<option value="kasir">kasir</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">Password <small class="text-muted">(isi saat tambah atau ganti)</small></label>
							<input type="password" class="form-control" name="password">
						</div>
					</div>
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
	const modal = new bootstrap.Modal(document.getElementById('userModal'));
	const form = document.getElementById('userForm');
	const errorsBox = document.getElementById('formErrors');
	let mode='create', currentId=null;

	document.getElementById('btnAdd').addEventListener('click', ()=>{
		mode='create'; currentId=null;
		document.getElementById('userModalLabel').textContent='Tambah Pengguna';
		form.reset(); errorsBox.classList.add('d-none');
		form.action='<?= site_url('users/create') ?>';
		modal.show();
	});

	document.querySelectorAll('#tblUsers .btnEdit').forEach(btn=>btn.addEventListener('click', function(){
		mode='update'; const tr=this.closest('tr'); currentId=tr.dataset.id;
		document.getElementById('userModalLabel').textContent='Edit Pengguna';
		form.reset(); errorsBox.classList.add('d-none');
		form.action='<?= site_url('users/update') ?>/' + currentId;
		form.nama_lengkap.value = tr.children[0].textContent.trim();
		form.username.value = tr.children[1].textContent.trim();
		form.level.value = tr.children[2].textContent.trim();
		modal.show();
	}));

	document.querySelectorAll('#tblUsers .btnDelete').forEach(btn=>btn.addEventListener('click', async function(){
		const tr=this.closest('tr');
		if(!confirm('Hapus pengguna ini?')) return;
		const res=await fetch('<?= site_url('users/delete') ?>/' + tr.dataset.id, {method:'POST'});
		if(res.ok) tr.remove();
	}));

	form.addEventListener('submit', async function(e){
		e.preventDefault();
		const res = await fetch(form.action, { method:'POST', body:new FormData(form) });
		const json = await res.json();
		if(!res.ok || json.status!=='ok'){
			errorsBox.classList.remove('d-none');
			errorsBox.innerHTML = Object.values(json.errors||{error:'Terjadi kesalahan'}).map(x=>`<div>${x}</div>`).join('');
			return;
		}
		const d=json.data;
		if(mode==='create'){
			const tr=document.createElement('tr'); tr.dataset.id=d.id;
			tr.innerHTML = `
				<td>${d.nama_lengkap}</td>
				<td>${d.username}</td>
				<td>${d.level}</td>
				<td>
					<button class=\"btn btn-sm btn-warning btnEdit\"><i class=\"bi bi-pencil-square\"></i></button>
					<button class=\"btn btn-sm btn-danger btnDelete\"><i class=\"bi bi-trash\"></i></button>
				</td>`;
			document.querySelector('#tblUsers tbody').prepend(tr);
			tr.querySelector('.btnEdit').addEventListener('click', function(){
				mode='update'; currentId=tr.dataset.id;
				document.getElementById('userModalLabel').textContent='Edit Pengguna';
				form.action='<?= site_url('users/update') ?>/' + currentId;
				form.nama_lengkap.value = tr.children[0].textContent.trim();
				form.username.value = tr.children[1].textContent.trim();
				form.level.value = tr.children[2].textContent.trim();
				modal.show();
			});
			tr.querySelector('.btnDelete').addEventListener('click', async function(){
				if(!confirm('Hapus pengguna ini?')) return;
				const res=await fetch('<?= site_url('users/delete') ?>/' + tr.dataset.id, {method:'POST'});
				if(res.ok) tr.remove();
			});
		}else{
			const row=document.querySelector(`#tblUsers tbody tr[data-id="${currentId}"]`);
			row.children[0].textContent = d.nama_lengkap;
			row.children[1].textContent = d.username;
			row.children[2].textContent = d.level;
		}
		modal.hide();
	});
})();
</script>
<?= $this->endSection() ?>
