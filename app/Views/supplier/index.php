<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h4 class="m-0">Manajemen Supplier</h4>
	<button class="btn btn-primary" id="btnAdd"><i class="bi bi-plus-lg me-1"></i> Tambah Supplier</button>
</div>
<div class="card border-0 shadow-sm">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped align-middle" id="tblSupplier">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Telepon</th>
						<th>Alamat</th>
						<th width="120">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $it): ?>
						<tr data-id="<?= $it['id'] ?>">
							<td><?= esc($it['nama_supplier']) ?></td>
							<td><?= esc($it['telepon']) ?></td>
							<td><?= esc($it['alamat']) ?></td>
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

<div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<form id="supplierForm">
				<div class="modal-header">
					<h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-md-6">
							<label class="form-label">Nama Supplier</label>
							<input type="text" class="form-control" name="nama_supplier" required>
						</div>
						<div class="col-md-6">
							<label class="form-label">Telepon</label>
							<input type="text" class="form-control" name="telepon">
						</div>
						<div class="col-12">
							<label class="form-label">Alamat</label>
							<textarea class="form-control" name="alamat" rows="3"></textarea>
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
	const modal = new bootstrap.Modal(document.getElementById('supplierModal'));
	const form = document.getElementById('supplierForm');
	const errorsBox = document.getElementById('formErrors');
	let mode='create', currentId=null;

	document.getElementById('btnAdd').addEventListener('click', ()=>{
		mode='create'; currentId=null;
		document.getElementById('supplierModalLabel').textContent='Tambah Supplier';
		form.reset(); errorsBox.classList.add('d-none');
		form.action='<?= site_url('supplier/create') ?>';
		modal.show();
	});

	document.querySelectorAll('#tblSupplier .btnEdit').forEach(btn=>btn.addEventListener('click', function(){
		mode='update';
		const tr=this.closest('tr'); currentId=tr.dataset.id;
		document.getElementById('supplierModalLabel').textContent='Edit Supplier';
		form.reset(); errorsBox.classList.add('d-none');
		form.action='<?= site_url('supplier/update') ?>/' + currentId;
		form.nama_supplier.value = tr.children[0].textContent.trim();
		form.telepon.value = tr.children[1].textContent.trim();
		form.alamat.value = tr.children[2].textContent.trim();
		modal.show();
	}));

	document.querySelectorAll('#tblSupplier .btnDelete').forEach(btn=>btn.addEventListener('click', async function(){
		const tr=this.closest('tr');
		if(!confirm('Hapus supplier ini?')) return;
		const res=await fetch('<?= site_url('supplier/delete') ?>/' + tr.dataset.id, {method:'POST'});
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
				<td>${d.nama_supplier}</td>
				<td>${d.telepon||''}</td>
				<td>${d.alamat||''}</td>
				<td>
					<button class=\"btn btn-sm btn-warning btnEdit\"><i class=\"bi bi-pencil-square\"></i></button>
					<button class=\"btn btn-sm btn-danger btnDelete\"><i class=\"bi bi-trash\"></i></button>
				</td>`;
			document.querySelector('#tblSupplier tbody').prepend(tr);
			tr.querySelector('.btnEdit').addEventListener('click', function(){
				mode='update'; currentId=tr.dataset.id;
				document.getElementById('supplierModalLabel').textContent='Edit Supplier';
				form.action='<?= site_url('supplier/update') ?>/' + currentId;
				form.nama_supplier.value = tr.children[0].textContent.trim();
				form.telepon.value = tr.children[1].textContent.trim();
				form.alamat.value = tr.children[2].textContent.trim();
				modal.show();
			});
			tr.querySelector('.btnDelete').addEventListener('click', async function(){
				if(!confirm('Hapus supplier ini?')) return;
				const res=await fetch('<?= site_url('supplier/delete') ?>/' + tr.dataset.id, {method:'POST'});
				if(res.ok) tr.remove();
			});
		}else{
			const row=document.querySelector(`#tblSupplier tbody tr[data-id="${currentId}"]`);
			row.children[0].textContent = d.nama_supplier;
			row.children[1].textContent = d.telepon||'';
			row.children[2].textContent = d.alamat||'';
		}
		modal.hide();
	});
})();
</script>
<?= $this->endSection() ?>
