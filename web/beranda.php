<!DOCTYPE html>

<?php
include "connection/koneksi.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if(isset ($_SESSION['username'])){
  
  $query = "select * from tb_user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  //Jumlah Administrator
  $query_jml_adm = "select count(*) AS jumlah_adm from tb_user natural join tb_level where id_level = 1 and status = 'aktif'";
  $sql_jml_adm = mysqli_query($conn, $query_jml_adm);
  $result_adm = mysqli_fetch_array($sql_jml_adm);

  //Jumlah Kasir
  $query_jml_ksr = "select count(*) AS jumlah_ksr from tb_user natural join tb_level where id_level = 2 and status = 'aktif'";
  $sql_jml_ksr = mysqli_query($conn, $query_jml_ksr);
  $result_ksr = mysqli_fetch_array($sql_jml_ksr);

  //Jumlah Owner
  $query_jml_own = "select count(*) AS jumlah_own from tb_user natural join tb_level where id_level = 3 and status = 'aktif'";
  $sql_jml_own = mysqli_query($conn, $query_jml_own);
  $result_own = mysqli_fetch_array($sql_jml_own);

  //Jumlah Pelanggan
  $query_jml_plg = "select count(*) AS jumlah_plg from tb_user natural join tb_level where id_level = 4 and status = 'aktif'";
  $sql_jml_plg = mysqli_query($conn, $query_jml_plg);
  $result_plg = mysqli_fetch_array($sql_jml_plg);

  while($r = mysqli_fetch_array($sql)){
    
    $nama_user = $r['nama_user'];
    //$id_level = $r['id_level'];

?>

<html lang="en">
<head>
<title>Beranda</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="./template/dashboard/css/bootstrap.min.css" />
<link rel="stylesheet" href="./template/dashboard/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="./template/dashboard/css/fullcalendar.css" />
<link rel="stylesheet" href="./template/dashboard/css/matrix-style.css" />
<link rel="stylesheet" href="./template/dashboard/css/matrix-media.css" />
<link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="./template/dashboard/css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="beranda.php">Beranda</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php echo $r['nama_user'];?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i><?php echo "&nbsp;&nbsp;".$r['nama_level'];?></a></li>
        <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->

<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="beranda.php" class="visible-phone"><i class="icon icon-home"></i> Beranda</a>
  <ul>
  <?php
    if($r['id_level'] == 1){
  ?>
    <li class="active"><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="akun.php"><i class="icon icon-user"></i> <span>Kelola Akun</span></a> </li>
    <li> <a href="entri_referensi.php"><i class="icon icon-tasks"></i> <span>Kelola Menu & Harga</span></a> </li>
    <!-- <li> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li> -->
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Entri Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 2){
  ?>
    <li class="active"><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li>
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Entri Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 3){
  ?>
    <li class="active"><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 4){
  ?>
    <li class="active"><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 5){
  ?>
    <li class="active"><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    }
  ?>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="beranda.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Beranda</a></div>
  </div>
<!--End-breadcrumbs-->
  
<!--Action boxes-->
  <div class="container-fluid">
    <div class="row-fluid">
    <?php
      if($r['id_level'] == 1 || $r['id_level'] == 2 || $r['id_level'] == 3){
    ?>
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Data Pengguna</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span3">
              <div class="widget-box">
                <div class="widget-content nopadding">
                  <ul class="site-stats quick-actions">
                    <li class="bg_lb"><i class="icon-user"></i> <strong><?php echo $result_adm['jumlah_adm']; ?></strong> <small>Administrator</small></li>
                    <li class="bg_lg"><i class="icon-user"></i> <strong><?php echo $result_ksr['jumlah_ksr']; ?></strong> <small>Total Kasir</small></li>
                    <li class="bg_ls"><i class="icon-user"></i> <strong><?php echo $result_own['jumlah_own']; ?></strong> <small>Total Owner</small></li>
                    <li class="bg_lo"><i class="icon-user"></i> <strong><?php echo $result_plg['jumlah_plg']; ?></strong> <small>Total Pelanggan</small></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        } else {
      ?>
      <div class="alert alert-orange alert-block">
        <center>
          <h4 class="alert-heading">SELAMAT DATANG</h4>
          Di Sistem Pelayanan Restaurant Cepat Saji.
          <br> Semoga Hari Anda Menyenangkan.
        </center>
      </div>
      <?php
        }
      ?>
    </div>
<!--End-Action boxes-->    
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<?php include "footer.php"; ?>

<!--end-Footer-part-->

<script src="template/dashboard/js/excanvas.min.js"></script> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.resize.min.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/fullcalendar.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/matrix.dashboard.js"></script> 
<script src="template/dashboard/js/jquery.gritter.min.js"></script> 
<script src="template/dashboard/js/matrix.interface.js"></script> 
<script src="template/dashboard/js/matrix.chat.js"></script> 
<script src="template/dashboard/js/jquery.validate.js"></script> 
<script src="template/dashboard/js/matrix.form_validation.js"></script> 
<script src="template/dashboard/js/jquery.wizard.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.popover.js"></script> 
<script src="template/dashboard/js/jquery.dataTables.min.js"></script> 
<script src="template/dashboard/js/matrix.tables.js"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
<?php
  }
} else {
  header('location: logout.php');
}
ob_flush();
?>