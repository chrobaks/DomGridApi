<?php $view = $view ?? []; ?>
<div class="col-dialog-sm">
    <div class="col-dialog-label">
        <div class="row"><div class="col-12"><p><?=$view['pageTitle'];?></p></div></div>
    </div>
    <div class="form-container" data-grid-name-space="UserLogin"  data-grid-component="GridForm">
        <form action="<?=AppTpl::route(['login','login']);?>" method="post">
            <div class="row space-bottom">
                <div class="col-4 text-align-r-space"><?=AppTpl::renderFormLabel($view["form"]->userName);?></div>
                <div class="col-6"><?=AppTpl::renderFormElement($view["form"]->userName);?></div>
            </div>
            <div class="row space-bottom">
                <div class="col-4 text-align-r-space"><?=AppTpl::renderFormLabel($view["form"]->password);?></div>
                <div class="col-6"><?=AppTpl::renderFormElement($view["form"]->password);?></div>
            </div>
            <?php if (isset($view['formMsg'])):?>
            <div class="row space-bottom">
                <div class="col-4"></div>
                <div class="col-6"><?=AppTpl::alert($view["formMsg"], "alert-info");?></div>
            </div>
            <?php else:?>
            <div class="row space-bottom">
                <div class="col-4"></div>
                <div class="col-6">Bitte Benutzername und Passwort eingeben.</div>
            </div>
            <?php endif;?>
            <div class="row space-top">
                <div class="col-4"></div>
                <div class="col-6"><?=AppTpl::renderFormElement($view["form"]->btnSubmit);?></div>
            </div>
        </form> 
    </div>
</div>