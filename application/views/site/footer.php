</div> <!--/container-->
<footer class="footer-bar">
    <div class="container">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="col-sm-5">
                <img src="<?php echo base_url() ?>assets/img/site/logo-footer.png" class="img-responsive logo_footer" alt="Dinner 4 Friends" />
            </div>
            <div class="col-sm-3">
                <h4><strong>Navegue no Site</strong></h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo site_url() ?>">Home</a></li>
                    <li><a href="<?php echo site_url('sobre') ?>">Sobre nós</a></li>
                    <li><a href="<?php echo site_url('faq') ?>">Dúvidas Frequentes</a></li>
                    <li><a href="<?php echo site_url('contato') ?>">Fale Conosco</a></li>
                    <li><a href="<?php echo site_url('login') ?>">Área do Chef</a></li>
                </ul>
            </div>

            <div class="col-sm-4">
                <ul class="list-inline socialmedia">
                    <li class="col-xs-4"><a href=""><i class="fa fa-2x fa-youtube"></i></a></li>
                    <li class="col-xs-4"><a href="https://www.instagram.com/dinnerforfriends_app/" target="_blank"><i class="fa fa-2x fa-instagram"></i></a></li>
                    <li class="col-xs-4"><a href=""><i class="fa fa-2x fa-facebook-official"></i></a></li>
                </ul>
                <ul class="list-unstyled">
                    <li><a href="<?php echo site_url('termos') ?>">Termos de Uso</a></li>
                    <li><a href="<?php echo site_url('privacidade') ?>">Política de Privacidade</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMbjchaqX9paF4tEMBI7PLXxvxTXidysw&v=3.exp"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url() ?>assets/js/cadastro/jquery-1.9.1.js"></script>
<script src="<?php echo base_url() ?>assets/js/cadastro/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-mask.js"></script>
<script src="<?php echo base_url() ?>assets/js/cadastro/cadastro.js"></script>

<?php if (file_exists(FCPATH . 'assets/js/' . $this->uri->segment(1) . '.js')): ?>
    <script src="<?php echo base_url() ?>assets/js/<?php echo $this->uri->segment(1) ?>.js"></script>
<?php endif; ?>
<?php if (isset($view)): ?>
    <script>
        $(document).ready(function () {
            $("#menu_<?php echo $view; ?>").addClass('active');
        });
    </script>
<?php endif; ?>

<?php if (isset($jsFiles)): ?>
    <?php foreach ($jsFiles as $item): ?>
        <script src="<?php echo base_url().$item ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
