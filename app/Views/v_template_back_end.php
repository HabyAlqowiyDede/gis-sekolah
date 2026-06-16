<?php
$judul = $judul ?? '';
$page = $page ?? '';
$menu = $menu ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GIS Sekolah | <?= $judul ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/dist/css/adminlte.min.css">
  <!-- Leaflet -->
  <link rel="stylesheet " href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <!-- jQuery -->
  <script src="<?= base_url('AdminLTE3') ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('AdminLTE3') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('AdminLTE3') ?>/dist/js/adminlte.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- Select2 -->
  <script src="<?= base_url('AdminLTE3') ?>/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url('AdminLTE3') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?= base_url('AdminLTE3') ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

  <style>
  </style>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('Admin') ?>/index3.html" class="brand-link">
        <img src="<?= base_url('AdminLTE3') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">GIS Sekolah</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('AdminLTE3') ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= esc(session()->get('nama_user') ?? 'Admin') ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="<?= base_url('Admin')?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('Wilayah') ?>" class="nav-link <?= $menu == 'wilayah' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-layer-group"></i>
                  <p>
                    Wilayah
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('Jenjang') ?>" class="nav-link <?= $menu == 'jenjang' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-swimming-pool"></i>
                  <p>
                    Jenjang
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('Sekolah') ?>" class="nav-link <?= $menu == 'sekolah' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-school"></i>
                  <p>
                    sekolah
                  </p>
                </a>
              </li>

            <li class="nav-item">
              <a href="<?= base_url('User') ?>" class="nav-link <?= $menu == 'profil' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                  Profil
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('Admin/Setting') ?>/setting" class="nav-link <?= $menu == 'setting' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  setting
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('Admin/logout') ?>" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>

          </ul>
        </nav>

        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $judul ?></h1>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <?php
            if ($page) {
              echo view($page);
            }
            ?>
          </div>
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->


</body>

</html>
