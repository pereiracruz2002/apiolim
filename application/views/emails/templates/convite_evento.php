<div class="container">
    <h1>Olá <?php echo "{$convidado->name} {$convidado->lastname}"; ?>,</h1>
    <h3>Você foi convidado para o evento <?php echo $evento->name ?>.</h3>
    <h4>Que será realizado no dia <?php echo date("d/m/Y", strtotime($evento->start)) ?> das <?php echo date("H:i", strtotime($evento->start)) ?> horas até  <?php echo date("H:i", strtotime($evento->end)) ?> horas</h4>
    <h4>
        <b>Descrição do evento: </b><?php echo $evento->description ?><br/>
    </h4>
    <?php if (isset($evento->picture)): ?>
        <img src="<?php echo SITE_URL."uploads/{$evento->picture}" ?>" style="width: 400px;" />
    <?php endif; ?>
    <br/><br/>
    <h5>Abraço,<br/> equipe Dinner 4 Friends.</h5>
</div>