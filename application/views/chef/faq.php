<?php include_once(dirname(__FILE__).'/header.php'); ?>
<div class="well well-sm bg-white well-title">
    <h5><strong><?php echo $page_title ?></strong></h5>
</div>
<?php foreach ($faqs as $item): ?>
    <div class="well bg-white">
        <div class="row user_perfil">
            <div class="row block_title">
                <div class="col-sm-10 h5_info"><?php echo $item->title ?></div>
            </div>
        </div>
        <?php echo $item->description ?>
    </div>

<?php endforeach; ?>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
