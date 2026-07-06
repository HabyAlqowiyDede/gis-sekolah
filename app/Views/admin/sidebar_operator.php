<?php
$menu = $menu ?? '';
?>
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?= site_url('Sekolah') ?>" class="nav-link <?= $menu == 'sekolah' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-school"></i>
        <p>sekolah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('User/setting') ?>" class="nav-link <?= $menu == 'setting' ? 'active' : '' ?>">
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
