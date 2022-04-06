<?php $view = $view ?? []; ?>
<div>
    <div class="row space-top row-form">
        <div class="col-12">
            <p class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <small><b>Fehlermeldung: </b> <?=$view['error'];?></small>
            </p>
        </div>
    </div>
</div>