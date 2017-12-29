</div> <!--/col-sm-9-->
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
                    <li><a href="<?php echo site_url('privacidade') ?>">Termos de Uso</a></li>
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

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/croppie.js"></script>
<script src="<?php echo base_url() ?>assets/js/exif-js/exif.js"></script>
<script src="<?php echo base_url() ?>assets/js/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/cidades-estados-1.4-utf8.js"></script>
<script src="<?php echo base_url() ?>assets/js/chef/utility.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-mask.js"></script>

<?php if (isset($jsFiles)): ?>
    <?php foreach ($jsFiles as $item): ?>
        <script src="<?php echo base_url() ?>assets/js/<?php echo $item ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (file_exists(FCPATH . 'assets/js/chef/' . $this->uri->segment(2) . '.js') && $this->uri->segment(3) != "novo"): ?>
    <script src="<?php echo base_url() ?>assets/js/chef/<?php echo $this->uri->segment(2) ?>.js"></script>
<?php endif; ?>
</body>
<script>
    var url = "<?php echo SITE_URL ?>chef/amigos/solicitacoes";
    jQuery.getJSON(url, function (data) {
        if (data.solicitacoes) {
            $(".solicitacoes_badge").text(data.solicitacoes);
            console.log(data.solicitacoes > 0);
            if (data.solicitacoes > 0)
                $(".solicitacoes_badge").removeClass('hide');
            else
                $(".solicitacoes_badge").addClass('hide');
        }
    });
</script>
</html>
