<?php
$view = $view ?? [];
$msg = $view["msg"] ?? "";
?>
<style>
    tr.form-group th {
        background-color: #196fc0;
        color: #fff;
    }
    tr.form-group td {
        background-color: #3399CC;
        text-align: center;
    }
    tr.form-group td input {
        line-height:1.9em;
        width: calc(100% - 20px);
    }
    .text-warning {color: #ffcc00;}
</style>
<div class="grid-container grid-modal"<?=AppTpl::renderServiceRouteJs('deleteDataModal');?>>
<div class="row space-bottom space-top row-form">
    <div class="col-12">
        <?=AppTpl::renderFormElement($view["id"]);?>
        <b>Daten löschen:</b> <?=$view["name"];?>
        <p class="text-warning">
            <i class="fa fa-exclamation-triangle"></i>

            <small><b>Warnung: </b>Dieser Vorgang löscht unwiderruflich die Daten aus dem Speicher! <?=$msg;?></small>
        </p>
    </div>
</div>
</div>