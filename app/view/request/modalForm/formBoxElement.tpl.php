<?php $view = $view ?? []; ?>
<style>
    .container-data-table-modal-list {height: 420px; overflow-y: auto;margin:0;padding:0;}
</style>
<div class="grid-container grid-modal"<?php if(count($view["appElements"]) > 0):?><?=AppTpl::renderServiceRouteJs('formBoxElement');?><?php endif;?>>
    <?php if(count($view["appElements"]) < 1):?>
        <div class="row space-top row-form">
            <div class="col-12">
                <p class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <small><b>Information: </b> Keine neuen Elemente verfügbar.</small>
                </p>
            </div>
        </div>
    <?php else:?>

    <?=AppTpl::renderFormElement($view["form"]->customPackageId);?>
    <?=AppTpl::renderFormElement($view["form"]->userId);?>
    <div class="row space-bottom space-top row-form">
        <div class="col-4">
            <?=AppTpl::renderFormLabel($view["form"]->appElementType);?><br>
            <?=AppTpl::renderFormElement($view["form"]->appElementType);?>
        </div>
        <div class="col-4">
            <?=AppTpl::renderFormLabel($view["form"]->appElementEnvironment);?><br>
            <?=AppTpl::renderFormElement($view["form"]->appElementEnvironment);?>
        </div>
        <div class="col-4">
            <?=AppTpl::renderFormLabel($view["form"]->appElementStatus);?><br>
            <?=AppTpl::renderFormElement($view["form"]->appElementStatus);?>
        </div>
    </div>
    <div class="row space-top row-form">
        <div class="col-12">
            <p class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <small><b>Markierte Elemente: </b> <span class="container-info-check-length">0</span></small>
            </p>
        </div>
    </div>
    <div class="row space-bottom row-form">
        <div class="col-12 container-data-table-modal-list">
            <table class="dataTable table-highlight">
                <thead>
                <tr>
                    <th class="static-cell"><input type="checkbox" class="check-all"></th>
                    <th class="static-cell">Name</th>
                    <th class="static-cell">Type</th>
                    <th class="static-cell">Status</th>
                    <th class="static-cell">Bereich</th>
                    <th class="static-cell">Version</th>
                    <th class="static-cell">Gültig von</th>
                    <th class="static-cell">Gültig bis</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($view["appElements"] as $element):?>
                    <tr class="row-data">
                        <td class="txtCenter">
                            <?=AppTpl::renderInput([["name" => "id", "value" => $element["id"], "type" => "hidden"]]);?>
                            <input type="checkbox" class="check-item">
                        </td>
                        <td class="txtCenter"><?=$element["app_element_name"];?></td>
                        <td class="txtCenter" data-search-column="app_element_type"><?=$element["app_element_type"];?></td>
                        <td class="txtCenter" data-search-column="app_element_status"><?=$element["app_element_status"];?></td>
                        <td class="txtCenter" data-search-column="app_element_environment"><?=$element["app_element_environment"];?></td>
                        <td class="txtCenter"><?=$element["app_element_version"];?></td>
                        <td class="txtCenter"><?=$element["stable_date_start"];?></td>
                        <td class="txtCenter"><?=$element["stable_date_end"];?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif;?>
</div>
