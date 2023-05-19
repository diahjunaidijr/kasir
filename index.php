<?php 
	session_start();
	include('koneksi.php');

	// session : sebuah var system dari php untuk menyimpan data yang di daftarkan di dalam browser $_SESSSION[]
	if (isset($_POST['login'])) {
		// cari data dari table user dimana username bernilai dari inputan username dan password bernilai dari inputan password,  jika ketemu atau datanya ada maka lempar ke halaman dashboard selain itu kembali ke login

		// id, fullname,  username, password, created_at, updated_at
		// id itu biasanya bertipe data integer karna mau kita pakaikan auto_increment : memmbuat id nya di isi otomatis oleh mysql dan menjadi nomor urut

		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query = mysqli_query($koneksi, "SELECT * FROM tbl_user 
		WHERE username ='$username' AND password ='$password'");
		$cek_login = mysqli_num_rows($query);
		

		$row = mysqli_fetch_assoc($query);
		if ($cek_login > 0) {
			$_SESSION['USERNAME'] = $_POST['username'];
			$_SESSION['ID_USER']  = $row['id'];
			header("location:home.php");
		}else{
			header("location:index.php?login=gagal");
		}

	}
?>



<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LOGIN</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
			<style>
				.center {
					margin: 100px auto;
					float: none;
				}
			</style>
	</head>
	<body>
		<div class="row">
			<div class="col-sm-6 center">
				<div class="form-login">
					<div class="card">
						<div class="card-body">
							<?php if (isset($_GET['login']) AND $_GET['login'] == 'gagal'): ?>
								<div class="alert alert-warning">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Upss!</strong> Mohon Periksa Kembali Username dan Password Anda !!
								</div>
							<?php endif ?>
							<?php if (isset($_GET['login']) AND $_GET['login'] == 'access'): ?>
								<div class="alert alert-warning">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Upss!</strong> anda harus login terlebih dahulu !!
								</div>
							<?php endif ?>
							<h4 class="text-muted">LOGIN</h4>
							<form action="" method="post">
								<div class="form-group mb-3">
									<label for="">Username *</label>
									<input type="text" class="form-control" name="username" placeholder="Username" required>
								</div>
								<div class="form-group mb-3">
									<label for="">Password *</label>
									<input type="password" class="form-control" name="password" placeholder="Password" required>
								</div>
								<div class="form-group mb-3 row">
									<div class="col-sm-6">
										<input type="submit" class="btn btn-dark text-white w-50" name="login" value="Login">
									</div>
									<div class="col-sm-6" align="right">
										<a href="#" class="text-muted">Forgot Pasword?</a>
									</div>
								</div>
								<div class="form-group">
									<a href="register.html" class="text-muted">Not A User? Sign Up</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	</body>
</html>


<!-- 
	buat satu buah table bernama kategori (id, type:enum, name, created_at, updated_at)
 buat crud (listing, tambah, ubah, hapus)
kamis dikumpulkan


--> 