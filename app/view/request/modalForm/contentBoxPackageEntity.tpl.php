<?php
$view = $view ?? [];
$entity = $view['entity'] ?? [];
?>
<h5 class="box-item-icon show"><?=$entity["package_name"];?></h5>
<div class="box-item-info">
    <table>
        <tr>
            <td><b>Anzahl Elemente:</b></td>
            <td><?=$entity["element_count"];?></td>
        </tr>
        <tr>
            <td><b>Version:</b></td>
            <td><?=$entity["package_version"];?></td>
        </tr>
        <tr>
            <td><b>Beschreibung:</b></td>
            <td><?=$entity["package_description"];?></td>
        </tr>
    </table>
    <p>
        <button data-request-url="<?=AppRoute::getRoute(['request', 'customElement', 'formAdd',$entity["id"]]);?>"
                data-trigger-url="<?=AppRoute::getRoute(['request', 'customElement', 'add']);?>"
                class="btn btn-primary btn-fa btn-sm">
            <i class="fa fa-file-import" aria-hidden="true"></i>Neues Element hinzufügen
        </button>
    </p>
</div>
