<footer class="main-footer text-sm no-print">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        <b>Versão APP: </b> 3.0.2.1
        <b>Versão BD: </b> 2.0.1.16
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019 - <?php echo DATE('Y'); ?> <a href="<?= base_url('app/dashboard'); ?>"><?= (dadosEmpresa()->emp_fantasia) ? dadosEmpresa()->emp_fantasia : 'JB System'; ?></a>.</strong> Todos os direitos reservados.
</footer>