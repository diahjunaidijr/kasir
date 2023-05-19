<?php 
session_start();

// jika session ada dia bisa masuk ke halaman home, jika tidak ada kita lempar ke halaman login

if (empty($_SESSION['USERNAME'])) {
	header("location:index.php?login=access");
}

include 'koneksi.php';
// tampilkan seluruh data dari table user dimana urutannya dari yang terbesar ke terkecil

// $query = mysqli_query($koneksi, "SELECT * FROM tbl_user ORDER BY id DESC");
// jika tombol bernama add ditekan actionnya adalah: masukkan ke dalam tabel user nilainya diambil dari inputan, fullname=inputan fullname
// jika berhasil lempar ke halaman user, jika gagal balikin ke halaman tambah-user
if (isset($_POST['simpan'])) {
	$trans_number = $_POST['trans_number'];
	$table_number = $_POST['table_number'];
	$user_id = $_POST['user_id'];
	

	$insert = mysqli_query($koneksi, "INSERT INTO tbl_trans (trans_number, table_number, user_id) 
			VALUES ('$trans_number', '$table_number', '$user_id' )");

	if($insert) {
        // lempar ke halaman detail transaksi
		header("location:tambah-trans.php?succes&detail=".$trans_number);
	}
}
// delete
if (isset($_GET['delete'])) {
	$id = $_GET['delete']; // nilai id
	
	$delete = mysqli_query($koneksi, "DELETE FROM tbl_trans WHERE id='$id'");

	if($delete) {
		header("location:trans.php?hapus=berhasil");
	} else {
		header("location:trans.php?hapus=gagal");
	}
}


// edit
// ambil dari url maka pakai get
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];

	$editData = mysqli_query($koneksi, "SELECT * FROM tbl_menu WHERE id='$id'");
	$editData= mysqli_fetch_assoc($editData);
	// print_r($result);
}

// mengubah data dari yang sudah ada jadi baru berdasarkan primary key atau id
// lempar ke halaman user, gunakan post

if(isset($_POST['edit'])) {
	$id_kategori = $_POST['id_kategori'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$description = $_POST['description'];

	$update = mysqli_query($koneksi,"UPDATE tbl_menu 
			SET id_kategori = '$id_kategori', name='$name', price='$price', qty='$qty', 
			description='$description'  
			WHERE id='$id'");

	if($update) {
		header('location:menu.php?ubah=berhasil');
	}

}

$SESS_USERNAME = $_SESSION['USERNAME'];
$SESS_ID = $_SESSION['ID_USER'];

// cari di tabel transaksi datanya ada apa tidak? jika ada 1+1=2, jika tiadk ada maka 1
$query_invoice = mysqli_query($koneksi, "SELECT max(id) 
as trans_id FROM tbl_trans ORDER BY id DESC");
$row_invoice = mysqli_fetch_assoc($query_invoice);
// print_r($row_invoice); die;


$format_invoice = "inv";
if ($row_invoice['trans_id']){
    // datanya ada
    $no_invoice = $row_invoice['trans_id'] + 1;
    $no_invoice = $format_invoice."000".$no_invoice;
}else{
    // datanya tidak ada
    $no_invoice = $format_invoice."001";
}
// print_r($no_invoice);
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Menu</title>

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
			<?php include('inc/navbar.php') ?>

			
			<div class="container mt-5">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="card-title">
									<h3><?php echo isset($_GET['detail'])?'Detail':'Tambah' ?> Transaksi</h3>
								</div>
                                    <!-- detail transaksi -->

                                <?php if (isset($_GET['detail'])): ?>   
								<?php  else: ?>
                                                    
                                    <!-- tambah transaksi -->
                                <form action="" method="post">
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="">No Invoice</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="trans_number" 
                                            placeholder="No Invoice" readonly="" value="<?php echo $no_invoice;?>">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="">Nomor Meja</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="table_number" 
                                            placeholder="No Meja" value="">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="">Operator</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control"
                                            placeholder="Operator" readonly="" value="<?php echo isset($SESS_USERNAME)?$SESS_USERNAME:''; ?>">
                                        
                                            <input type="hidden" name="user_id" value="<?php echo isset($SESS_ID)?$SESS_ID:''; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                       
                                        <!-- <div>
                                           <button type="submit" name="simpan" class="btn btn-primary"></button>
                                        	</div> -->
                                        <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">

                                    </div>
                                   
                                </form>
								<?php endif ?>
                                

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