<!doctype html>
<html class="fixed">

<head>
	<?php include_once 'includes/head.php'; ?>

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="vendor/animate/animate.css">

	<link rel="stylesheet" href="vendor/font-awesome/css/fontawesome-all.min.css" />
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
	<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
	<link rel="stylesheet" href="vendor/select2/css/select2.css" />
	<link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" href="vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
	<link rel="stylesheet" href="vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="vendor/dropzone/basic.css" />
	<link rel="stylesheet" href="vendor/dropzone/dropzone.css" />
	<link rel="stylesheet" href="vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
	<link rel="stylesheet" href="vendor/codemirror/lib/codemirror.css" />
	<link rel="stylesheet" href="vendor/codemirror/theme/monokai.css" />
	<link rel="stylesheet" href="vendor/summernote/summernote.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="css/custom.css">

	<!-- Head Libs -->
	<script src="vendor/modernizr/modernizr.js"></script>

</head>

<body>
	<section class="body">

		<!-- start: header -->
		<?php include_once 'includes/header.php'; ?>
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left">

				<div class="sidebar-header">
					<div class="sidebar-title">
						Navigation
					</div>
					<div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
						<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

				<?php include 'includes/nav-bar.php'; ?>

			</aside>
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Farmer</h2>
				</header>
				<?php
				if (isset($_POST['product_id'])) {
					$product = "SELECT * FROM oc_product op,oc_product_description opd WHERE phnum='" . $_SESSION['farmer_num'] . "' and op.product_id=opd.product_id and op.product_id=" . $_POST['product_id'];

					$product = mysqli_query($conn, $product);
					$product = mysqli_fetch_assoc($product);
				}
				?>
				<!-- start: page -->
				<div class="row">
					<div class="col">
						<section class="card">
							<header class="card-header">
								<h2 class="card-title"><?php if (isset($_POST['product_id'])) {
															echo "Update";
														} else {
															echo "Add";
														} ?> Product</h2>
							</header>
							<div class="card-body">
								<div class="form-group row">
									<label class="col-lg-3 control-label text-lg-right pt-2" for="inputDefault">Product Name<span class="required">*</span></label>
									<div class="col-lg-6">

										<select data-plugin-selectTwo class="form-control populate" id='pro_id' <?php if (isset($_POST['product_id'])) {
																													echo "disabled";
																												} ?>>
											<option value=""> --SELECT-- </option>
											<?php
											$pro = "SELECT * FROM `oc_pro` WHERE 1";
											$pro = mysqli_query($conn, $pro);
											while ($pro_row = mysqli_fetch_assoc($pro)) {
											?>
												<option value="<?php echo $pro_row['pro_id']; ?>" <?php
																									if (isset($_POST['product_id'])) {
																										if ($pro_row['pro_id'] == $product['pro_id']) echo "selected";
																									}
																									?>> <?php echo $pro_row['pro_name']; ?> </option>
											<?php } ?>
										</select>
										<div id="name_err" style="color:red"></div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-3 control-label text-lg-right pt-2" for="inputDefault">Quantity<span class="required">*</span></label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="pro_quantity" value="<?php if (isset($_POST['product_id'])) {
																												echo $product['qnt'];
																											} ?>">
										<div id="quantity_err" style="color:red"></div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-3 control-label text-lg-right pt-2" for="inputDefault">Price(in Rs.)<span class="required">*</span></label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="pro_price" value="<?php if (isset($_POST['product_id'])) {
																											echo $product['price'];
																										} ?>">
										<div id="price_err" style="color:red"></div>
									</div>
								</div>

								<hr>
								<div class="form-group row">
									<div class="col-lg-6"></div>
									<div class="col-lg-3">
										<?php
										if (isset($_POST['product_id'])) {
											echo "<button class='btn btn-primary' id='update' style='width:100%;' onclick='upd();'>Update Product</button>";
										} else {
											echo "<button class='btn btn-primary' id='add' style='width:100%;' onclick='add_product();'>Add Product</button>";
										}
										?>
									</div>
									<input type="hidden" value="<?php if (isset($_POST['product_id'])) {
																	echo $_POST['product_id'];
																} ?>" id='product_id'>
									<div class="col-lg-3"></div>
								</div>
							</div>
						</section>
					</div>
				</div>
				<!-- end: page -->
			</section>
		</div>
	</section>

	<!-- Vendor -->
	<script src="vendor/jquery/jquery.js"></script>
	<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="vendor/popper/umd/popper.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.js"></script>
	<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="vendor/common/common.js"></script>
	<script src="vendor/nanoscroller/nanoscroller.js"></script>
	<script src="vendor/select2/js/select2.js"></script>
	<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
	<script src="vendor/jquery-placeholder/jquery-placeholder.js"></script>

	<!-- Specific Page Vendor -->
	<script src="vendor/jquery-ui/jquery-ui.js"></script>
	<script src="vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
	<script src="vendor/jquery-appear/jquery-appear.js"></script>
	<script src="vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
	<script src="vendor/flot/jquery.flot.js"></script>
	<script src="vendor/flot.tooltip/flot.tooltip.js"></script>
	<script src="vendor/flot/jquery.flot.pie.js"></script>
	<script src="vendor/flot/jquery.flot.categories.js"></script>
	<script src="vendor/flot/jquery.flot.resize.js"></script>
	<script src="vendor/jquery-sparkline/jquery-sparkline.js"></script>
	<script src="vendor/raphael/raphael.js"></script>
	<script src="vendor/morris/morris.js"></script>
	<script src="vendor/gauge/gauge.js"></script>
	<script src="vendor/snap.svg/snap.svg.js"></script>
	<script src="vendor/liquid-meter/liquid.meter.js"></script>
	<script src="vendor/jqvmap/jquery.vmap.js"></script>
	<script src="vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
	<script src="vendor/jqvmap/maps/jquery.vmap.world.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
	<script src="vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
	<script src="vendor/summernote/summernote.js"></script>


	<!-- Theme Base, Components and Settings -->
	<script src="js/theme.js"></script>

	<!-- Theme Custom -->
	<script src="js/custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="js/theme.init.js"></script>

	<!-- Examples -->
	<script src="js/examples/examples.dashboard.js"></script>
	<script>
		function add_product() {

			var pro_id = $('#pro_id').val();
			var pro_quantity = $('#pro_quantity').val();
			var pro_price = $('#pro_price').val();

			var ret = true;
			document.getElementById("name_err").innerHTML = "";
			document.getElementById("quantity_err").innerHTML = "";
			document.getElementById("price_err").innerHTML = "";

			if (pro_id == "") {
				document.getElementById("name_err").innerHTML = "Select Any Product.";
				ret = false;
			}

			if (pro_quantity == "") {
				document.getElementById("quantity_err").innerHTML = " Quantity Cannot Be Empty";
				ret = false;
			}
			if (pro_price == "") {
				document.getElementById("price_err").innerHTML = " Price Cannot Be Empty";
				ret = false;
			}


			if (ret == false) {
				return false;
			}

			$.ajax({
				url: 'queries/product.php',
				data: {
					pro_id: pro_id,
					pro_quantity: pro_quantity,
					pro_price: pro_price,
					product_add: ''
				},
				dataType: 'text',
				type: 'post',
				success: function(data) {
					alert(data);
					window.location = 'pro_view.php';
				},
				failure: function(data) {
					alert('Error While Adding Product.');
				}
			});
		}

		function upd() {
			var product_id = $('#product_id').val();
			var pro_quantity = $('#pro_quantity').val();
			var pro_price = $('#pro_price').val();

			var ret = true;
			document.getElementById("name_err").innerHTML = "";
			document.getElementById("quantity_err").innerHTML = "";
			document.getElementById("price_err").innerHTML = "";

			if (pro_quantity == "") {
				document.getElementById("quantity_err").innerHTML = " Quantity Cannot Be Empty";
				ret = false;
			}
			if (pro_price == "") {
				document.getElementById("price_err").innerHTML = " Price Cannot Be Empty";
				ret = false;
			}


			if (ret == false) {
				return false;
			}

			$.ajax({
				url: 'queries/product.php',
				data: {
					product_id: product_id,
					pro_quantity: pro_quantity,
					pro_price: pro_price,
					product_upd: ''
				},
				dataType: 'text',
				type: 'post',
				success: function(data) {
					alert(data);
					window.location = 'pro_view.php';
				},
				failure: function(data) {
					alert('Error While Adding Product.');
				}
			});
		}
	</script>
</body>

</html>