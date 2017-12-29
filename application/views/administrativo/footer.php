      </div>
    </div>
</div>
    <script>var site = "<?php echo SITE_URL; ?>";</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/chef/lightslider.js"></script>
    <script src="<?php echo base_url() ?>assets/js/croppie.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.maskMoney.min.js"></script>

    <script src="<?php echo base_url() ?>administrativo-assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>administrativo-assets/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo base_url() ?>administrativo-assets/js/utility.js"></script>
    <?php if (isset($jsFiles)): ?>
        <?php foreach ($jsFiles as $item): ?>
            <script src="<?php echo base_url() ?>administrativo-assets/js/<?php echo $item ?>"></script>
        <?php endforeach;?>
    <?php endif; ?>
    <?php if (file_exists(FCPATH.'administrativo-assets/js/'.$this->uri->segment(2).'.js')): ?>
    <script src="<?php echo base_url() ?>administrativo-assets/js/<?php echo $this->uri->segment(2) ?>.js"></script>
    <?php endif; ?>

  </body>
</html>

