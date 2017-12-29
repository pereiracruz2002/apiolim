<?php include_once(dirname(__FILE__).'/header.php'); ?>
<div class="well well-sm bg-white well-title">
    <h5><strong><?php echo $page_title ?></strong></h5>
</div>
<?php if (!$integracao): ?>
    <p class="text-center"><a href="<?php echo site_url('chef/pagseguro/autorizar') ?>"><img src="<?php echo base_url() ?>assets/img/chef/integrar_pagseguro.png" alt="Integrar com PagSeguro" /></a></p>
<?php else: ?>
    <p class="text-center"><a href="<?php echo site_url('chef/pagseguro/autorizar') ?>" class="btn btn-sm btn-danger">Integrar com outra conta do PagSeguro</a></p>
<?php endif; ?>
<?php include_once(dirname(__FILE__).'/footer.php'); ?>
