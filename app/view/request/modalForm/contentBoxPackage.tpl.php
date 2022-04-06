<?php $view = $view ?? []; ?>
<ul class="content-box-list">
    <?php foreach ($view["entities"] as $entity):?>
        <li class="content-box-item"
            data-grid-element="GridFormBoxElement"
            data-grid-element-id="GridFormBoxElement_<?=$entity["id"];?>"
            data-container-trigger-url="<?=AppRoute::getRoute(['request', 'customElement', 'contentBox', $entity["id"]]);?>"
            data-container-update-url="<?=AppRoute::getRoute(['request', 'customPackage', 'contentPackage', $entity["id"]]);?>"
            data-grid-watcher="GridCustomElement">
            <?=AppTpl::renderInput([["name" => "id", "value" => $entity["id"], "type" => "hidden"]]);?>

            <div class="box-item-icons box-item-top">
                <div class="box-item-icon show"><i class="fa fa-backward" aria-hidden="true"></i></div>
            </div>
            <div class="box-item-content">
                <?php AppTpl::renderTpl(VIEW_PATH.'request/modalForm/contentBoxPackageEntity.tpl.php', ["entity" => $entity]);?>
            </div>

            <div class="box-item-icons box-item-bottom">
                <div class="box-item-icon edit"
                     data-request-url="<?=AppRoute::getRoute(['request', 'customPackage', 'formAdd', $entity["id"]]);?>"
                     data-trigger-url="<?=AppRoute::getRoute(['request', 'customPackage', 'add']);?>"><i class="fa fa-file-import" aria-hidden="true"></i></div>
                <div class="box-item-icon delete"
                     data-request-url="<?=AppRoute::getRoute(['request', 'customPackage', 'formDelete', $entity["id"]]);?>"
                     data-trigger-url="<?=AppRoute::getRoute(['request', 'customPackage', 'delete']);?>"><i class="fa fa-trash" aria-hidden="true"></i></div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
