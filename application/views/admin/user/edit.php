<!doctype html>
<html lang="en">

<head>

	<?php $this->load->view('_parts/style') ?>
</head>


<body>
	<!-- Begin page -->
	<div id="layout-wrapper">



		<?php $this->load->view('_parts/header') ?>
		<?php $this->load->view('_parts/sidebar') ?>

		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content" style="margin-top:100px;">
			<div class="page-content">
				<div class="container-fluid">
					<div class="page-content-wrapper">
						<div class="mt-3">

							<h3 class=""><strong>Edit <?= $title ?></strong></h3>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="card">
									<div class="card-body">
										<div class="p-0">
											<p>Berikut adalah form edit node. silahkan lengkapi data-data dibawah ini dengan lengkap dan benar</p>
											<hr />
											<form action="<?= site_url('admin/user/edit/' . $userRow->id) ?>" method="POST" enctype="multipart/form-data">
												<input type="hidden" name="id" value="<?= $userRow->id ?>">
												<div class="form-group">
													<label>Username</label>
													<input type="text" name="username" class="form-control" value="<?= $userRow->username ?>">
													<?= form_error('username') ?>
												</div>
												<div class="form-group">
													<label>Rule</label><br><small>admin/user</small>
													<input type="text" name="rule" class="form-control" value="<?= $userRow->rule ?>">
													<?= form_error('rule') ?>
												</div>
												<div class="form-group">
													<label>Password</label>
													<input type="text" name="password" class="form-control" value="<?= $userRow->password ?>">
													<?= form_error('password') ?>
												</div>

												<div class="form-group mt-3">
													<a href="<?= site_url('admin/user') ?>" class="btn btn-light">Kembali</a>
													<button class="btn btn-primary">Simpan</button>
												</div>

											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card">
									<div class="card-body">
										<div id="map" style="height: 450px;width: 100%;"></div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div> <!-- container-fluid -->
			</div>
			<!-- End Page-content -->



			<?php $this->load->view('_parts/footer') ?>
		</div>
		<!-- end main content-->

	</div>
	<!-- END layout-wrapper -->

	<?php $this->load->view('_parts/js') ?>
	<script type="text/javascript">
		mapboxgl.accessToken = 'pk.eyJ1IjoiZWZoYWwiLCJhIjoiY2ptOXRiZ3k2MDh4bzNrbnljMjk5Z2d5aSJ9.8dSNgeAjpdTlZ3x-b2vsog';
		var map = new mapboxgl.Map({
			container: 'map', // container id
			style: 'mapbox://styles/mapbox/streets-v9', // stylesheet location
			center: [<?= DEFAULT_LNG ?>, <?= DEFAULT_LAT ?>], // starting position [lng, lat]
			zoom: <?= DEFAULT_ZOOM ?>, // starting zoom
			logoPosition: 'top-right',
		});

		var marker;
		map.on('click', function(e) {
			if (marker) {
				marker.remove();
			}
			marker = new mapboxgl.Marker({
					color: "#7d000c",
				})
				.setLngLat(e.lngLat)
				.addTo(map);
			$("#lat").val(e.lngLat.lat);
			$("#lng").val(e.lngLat.lng);
		})

		var markers = [];

		$.ajax({
			'url': "<?= site_url('admin/rs/ajax/data') ?>",
			'type': 'POST',
			success: function(e) {
				var data_obj = JSON.parse(e);
				data_obj.forEach(function(i) {
					console.log(i)
					markers.push(new mapboxgl.Marker()
						.setLngLat([i.lng, i.lat])
						.setPopup(new mapboxgl.Popup().setHTML(`
						<div class="card" style="width: 18rem;">
						<img src="<?= base_url('uploads/') ?>${i.picture}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">${i.name}</h5>
							<p class="card-text text-dark">${i.desc}</p>
						</div>
						</div>
						`)) // add popup
						.addTo(map));
				})
			}

		});
	</script>
</body>

</html>
