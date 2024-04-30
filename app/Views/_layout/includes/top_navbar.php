<li class="nav-item">
    <a href="<?= base_url('/autenticacao/logout'); ?>" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
        <p> DESLOGAR</p>
    </a>
</li>
<div class="user-panel d-flex">
</div>
<!-- Menu Dashboard -->
<li class="nav-item">
    <a href="<?= base_url('app/dashboard'); ?>" class="nav-link <?= (url_is('app/dashboard')) ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-laptop"></i>
        <p>DASHBOARD</p>
    </a>
</li>