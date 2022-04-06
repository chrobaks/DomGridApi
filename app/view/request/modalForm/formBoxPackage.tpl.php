<?php $view = $view ?? []; ?>

<div class="grid-container grid-modal"<?=AppTpl::renderServiceRouteJs('formBoxPackage');?>>
    <div class="row space-bottom row-form">
        <div class="col-6">
            <?=AppTpl::renderFormElement($view["form"]->id);?>
            <?=AppTpl::renderFormElement($view["form"]->userId);?>
            <?=AppTpl::renderFormLabel($view["form"]->packageName);?><br>
            <?=AppTpl::renderFormElement($view["form"]->packageName);?>
        </div>
    </div>
    <div class="row space-bottom space-top row-form">
        <div class="col-6">
            <?=AppTpl::renderFormLabel($view["form"]->packageDescription);?><br>
            <?=AppTpl::renderFormElement($view["form"]->packageDescription);?>
        </div>
        <div class="col-4">
            <?=AppTpl::renderFormLabel($view["form"]->packageVersion);?><br>
            <?=AppTpl::renderFormElement($view["form"]->packageVersion);?>
        </div>
    </div>
    <div class="row space-bottom space-top row-form">
        <div class="col-6">
            <small>*Dieses Feld benötigt einen Eintrag.</small>
        </div>
    </div>
    <div class="row space-bottom space-top row-form">
        <div class="col-12">
            <p><b>Das Custom Package hat folgende Einträge</b></p>
            <table class="dataTable">
                <tr>
                    <td class="td-label"><?=$view["form"]->packageName["label"];?></td>
                    <td data-form-result="<?=$view["form"]->packageName["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->packageDescription["label"];?></td>
                    <td data-form-result="<?=$view["form"]->packageDescription["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->packageVersion["label"];?></td>
                    <td data-form-result="<?=$view["form"]->packageVersion["name"];?>"></td>
                </tr>
            </table>
        </div>
    </div>
</div>