<?php $view = $view ?? []; ?>
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
    .grid-modal input {
        width: calc(100% - 20px);
    }
    .grid-modal input.date-picker {
        text-align: center;
    }
</style>
<div class="grid-container grid-modal"<?=AppTpl::renderServiceRouteJs('formAppElement');?>>
    <div class="row space-bottom row-form">
        <div class="col-6">
            <?=AppTpl::renderFormElement($view["form"]->id);?>
            <?=AppTpl::renderFormElement($view["form"]->userId);?>
            <?=AppTpl::renderFormLabel($view["form"]->appElementName);?><br>
            <?=AppTpl::renderFormElement($view["form"]->appElementName);?>
        </div>
    </div>
<div class="row space-bottom space-top row-form">
    <div class="col-6">
        <?=AppTpl::renderFormLabel($view["form"]->appElementDescription);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementDescription);?>
    </div>
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->appElementSource);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementSource);?>
    </div>
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->appElementVersion);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementVersion);?>
    </div>
</div>
<div class="row space-bottom space-top row-form">
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->stableDateStart);?><br>
        <?=AppTpl::renderFormElement($view["form"]->stableDateStart);?>
    </div>
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->stableDateEnd);?><br>
        <?=AppTpl::renderFormElement($view["form"]->stableDateEnd);?>
    </div>
</div>
<div class="row space-bottom space-top row-form">
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->appElementType);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementType);?>
    </div>
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->appElementStatus);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementStatus);?>
    </div>
    <div class="col-3">
        <?=AppTpl::renderFormLabel($view["form"]->appElementEnvironment);?><br>
        <?=AppTpl::renderFormElement($view["form"]->appElementEnvironment);?>
    </div>
</div>
    <div class="row space-bottom space-top row-form">
        <div class="col-6">
            <small>*Dieses Feld benötigt einen Eintrag</small>
        </div>
    </div>
    <div class="row space-bottom space-top row-form">
        <div class="col-12">
            <p><b>Der Datensatz hat folgende Einträge</b></p>
            <table class="dataTable">
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementName["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementName["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementDescription["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementDescription["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementSource["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementSource["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementVersion["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementVersion["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->stableDateStart["label"];?></td>
                    <td data-form-result="<?=$view["form"]->stableDateStart["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->stableDateEnd["label"];?></td>
                    <td data-form-result="<?=$view["form"]->stableDateEnd["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementType["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementType["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementStatus["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementStatus["name"];?>"></td>
                </tr>
                <tr>
                    <td class="td-label"><?=$view["form"]->appElementEnvironment["label"];?></td>
                    <td data-form-result="<?=$view["form"]->appElementEnvironment["name"];?>"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
