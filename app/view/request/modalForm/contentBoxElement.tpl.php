<?php $view = $view ?? []; ?>
<ul class="content-box-list">
<?php foreach ($view["entities"] as $entity):?>
    <li class="content-box-item elements" data-content-id="<?=$entity["app_element_type"];?>">
        <?=AppTpl::renderInput([
            ["name" => "id", "value" => $entity["id"], "type" => "hidden"],
            ["name" => "package_id", "value" => $entity["custom_package_id"], "type" => "hidden"]
        ]);?>

        <div class="box-item-icons box-item-top">
            <div class="box-item-icon show"><i class="fa fa-backward" aria-hidden="true"></i></div>
        </div>
        <h5 class="box-item-icon show"><?=$entity["app_element_name"];?></h5>
        <div class="box-item-info">
            <table>
                <tr>
                    <td><b>Package:</b></td>
                    <td colspan="1"><?=$entity["package_name"];?></td>
                </tr>
                <tr>
                    <td><b>Type:</b></td>
                    <td><?=$entity["app_element_type"];?></td>
                    <td><b>Version:</b></td>
                    <td><?=$entity["app_element_version"];?></td>
                </tr>
                <tr>
                    <td><b>Gültig von:</b></td>
                    <td><?=$entity["stable_date_start"];?></td>
                    <td><b>Gültig bis:</b></td>
                    <td><?=$entity["stable_date_end"];?></td>
                </tr>
                <tr>
                    <td><b>Datei:</b></td>
                    <td colspan="1"><?=$entity["app_element_source"];?></td>
                </tr>
                <tr>
                    <td><b>Beschreibung:</b></td>
                    <td colspan="1"><?=$entity["app_element_description"];?></td>
                </tr>
            </table>
        </div>
        <div class="box-item-icons box-item-bottom">
            <div class="box-item-icon delete"
                 data-request-url="<?=AppRoute::getRoute(['request', 'customElement', 'formDelete', $entity["id"]]);?>"
                 data-trigger-url="<?=AppRoute::getRoute(['request', 'customElement', 'delete']);?>"><i class="fa fa-trash" aria-hidden="true"></i></div>
        </div>
    </li>
<?php endforeach;?>
</ul>
