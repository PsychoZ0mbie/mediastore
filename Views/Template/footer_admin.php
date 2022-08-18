    
            <footer class="footer">
                <div>CoreUI Bootstrap Admin Template © 2021 creativeLabs.</div>
                <div class="ms-auto">Powered by&nbsp; CoreUI UI Components</div>
            </footer>
        </div>
        
        <!-- Essential javascripts for application to work-->
        <script src="<?= media();?>/js/plugins/jquery/jquery.js"></script>
        <script src="<?= media(); ?>/js/bootstrap/popper.min.js?n=1"></script>
        <script src="<?= media(); ?>/js/bootstrap/bootstrap.min.js?n=1"></script>
        <script src="<?= media();?>/js/icons/fontawesome.js"></script>
        <script src="<?= media();?>/js/plugins/sweetalert.js"></script>
        
        <!-- AdminKit JS file -->
        <script src="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
        <script src="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/simplebar/js/simplebar.min.js"></script>
        <script src="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/utils/js/coreui-utils.js"></script>
        
        <!-- Hightcharts plugin-->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>

        <!-- Datepicker plugin-->
        <script src="<?= media();?>/js/plugins/datepicker/jquery-ui.min.js"></script>
        <script src="<?= media();?>/js/plugins/sheetjs/sheetjs.js"></script>
        <!-- My scripts -->
        <script>
          const base_url = "<?= base_url(); ?>";
          const MS = "<?=MS;?>";
          const MD = "<?=MD?>";
        </script>
        
        <script type="text/javascript" src="<?= media(); ?>/js/functions.js"></script>
        <script src="<?= media(); ?>/js/<?=$data['app']?>"></script>
    </body>
</html>
    
