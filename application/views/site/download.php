<?php include_once(dirname(__FILE__) . '/header.php'); ?>

<div class="well well-download">
    <div class="row">
        <div class="col-sm-12">
            <h1>Faça parte da rede de amigos no Dinner for Friends.</h1>
            <h2>Baixe o App para o seu dispositivo e desfrute!</h2>
        </div>
        <div class="col-sm-6 col-sm-offset-3">
            <div class="col-sm-6" style="text-align: center;">
                <a href="<?php echo $Android['browser']; ?>" target="_blank">
                    <img src="<?php echo base_url() ?>assets/img/playstore.png" />
                </a>
            </div>
            <div class="col-sm-6" style="text-align: center;">
                <a href="<?php echo $iOS['browser']; ?>" target="_blank">
                    <img src="<?php echo base_url() ?>assets/img/appstore.png" />
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once(dirname(__FILE__) . '/footer.php'); ?>