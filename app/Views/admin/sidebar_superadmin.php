<?php
$menu = $menu ?? '';
?>
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?= site_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('wilayah') ?>" class="nav-link <?= $menu == 'wilayah' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-layer-group"></i>
        <p>Wilayah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('Sekolah') ?>" class="nav-link <?= $menu == 'sekolah' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-school"></i>
        <p>sekolah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('User') ?>" class="nav-link <?= $menu == 'profil' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>User manage</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('Admin/Setting') ?>" class="nav-link <?= $menu == 'setting' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-cogs"></i>
        <p>setting</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('Admin/logout') ?>" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
    </li>
</ul>
