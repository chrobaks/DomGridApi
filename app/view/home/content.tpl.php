<?php $view = $view ?? []; ?>
<div class="grid-container">
    <div class="row">
        <div class="col-12 col-page-title" data-grid-name-space="ContentMenu">
            <ul class="content-menu" data-grid-component="GridContentMenu" data-grid-component-id="GridContentMenuMainTabs">
                <li class="content-menu-item active" data-content-menu-id="AppElementDataTable"><a><i class="fa fa-file-excel" aria-hidden="true"></i>AppElemente</a></li>
                <li class="content-menu-item" data-content-menu-id="AppElementImport"><a><i class="fa fa-file-excel" aria-hidden="true"></i>Import AppElemente</a></li>
                <li class="content-menu-item" data-content-menu-id="CustomPackage"><a><i class="fa fa-file-excel" aria-hidden="true"></i>Custom Package</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="task-container">
    <div class="task content-menu-data active" data-menu-data-id="GridContentMenuMainTabs" data-grid-name-space="AppElementDataTable">
        <div class="task-content">
            <div class="grid-container grid-content">
                <div class="row"
                     data-grid-component="GridFormModal"
                     data-grid-component-id="GridAppElement"
                     data-grid-component-response="GridAppElementDataTable,refreshDataTable"
                     data-grid-watcher="GridAppElementDataTable">
                    <div class="col-12 col-flex">
                        <button data-request-url="<?=AppRoute::getRoute(['request', 'appElement', 'formAppElement']);?>"
                                data-trigger-url="<?=AppRoute::getRoute(['request', 'appElement', 'add']);?>"
                                class="btn btn-primary btn-fa btn-sm"><i class="fa fa-file-import" aria-hidden="true"></i>Neue Daten anlegen</button>
                        <div class="container-msg"><span class="component-msg"></span></div>
                    </div>
                </div>
                <div class="row space-top space-bottom">
                    <div class="col-12"
                         data-grid-component="GridAppElementDataTable"
                         data-grid-module="GridDataTable"
                         data-grid-component-id="GridAppElementDataTable"
                         data-grid-watcher="GridFormImport,GridCustomPackage,GridCustomElement"
                         data-request-url="<?=AppRoute::getRoute(['request', 'appElement', '']);?>"
                         data-container-url="<?=AppRoute::getRoute(['request', 'appElement', 'dataTable']);?>"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="task content-menu-data" data-menu-data-id="GridContentMenuMainTabs" data-grid-name-space="AppElementImport">
        <div class="task-content">
            <div class="grid-container grid-content"
                 data-grid-component="GridFormFilter"
                 data-grid-component-id="GridFormImport"
                 data-grid-module="GridListCheckModule,GridTableSearchModule"
                 data-container-request-url="<?=AppRoute::getRoute(['request', 'appElement', 'add']);?>"
                 data-container-trigger-url="<?=AppRoute::getRoute(['request', 'appElement', 'formImport']);?>"
                 data-grid-watcher="GridAppElementDataTable">
                <div class="row space-bottom row-form">
                    <div class="col-12 col-flex">
                        <button class="btn btn-primary btn-fa btn-sm"><i class="fa fa-file-import" aria-hidden="true"></i>Markierte Elemente (<span class="info-data-length">0</span>) importieren</button>
                        <div class="container-msg"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="component-msg"></span></div>
                    </div>
                </div>
                <div class="row space-bottom space-top row-form">
                    <div class="col-6 col-flex-space-a">
                        <div>
                            <?=AppTpl::renderFormLabel($view["formElementOption"]->appElementType);?><br>
                            <?=AppTpl::renderFormElement($view["formElementOption"]->appElementType);?>
                        </div>
                        <div>
                            <?=AppTpl::renderFormLabel($view["formElementOption"]->appElementEnvironment);?><br>
                            <?=AppTpl::renderFormElement($view["formElementOption"]->appElementEnvironment);?>
                        </div>
                        <div>
                            <?=AppTpl::renderFormLabel($view["formElementOption"]->appElementStatus);?><br>
                            <?=AppTpl::renderFormElement($view["formElementOption"]->appElementStatus);?>
                        </div>
                    </div>
                </div>
                <div class="row space-top row-form">
                    <div class="col-12">
                        <p class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            <small><b>Markierte Elemente: </b> <b class="info-data-length">0</b></small>
                        </p>
                    </div>
                </div>
                <div class="row row-form">
                    <div class="col-12">
                        <div class="dataTable-wrapper">
                        <table class="dataTable table-highlight">
                            <?php include_once $view['importView'];?>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="task content-menu-data" data-menu-data-id="GridContentMenuMainTabs" data-grid-name-space="CustomPackage">
        <div class="task-content">
            <div class="grid-container grid-content">
                <div class="row"
                     data-grid-component="GridFormModal"
                     data-grid-component-id="GridCustomPackage"
                     data-grid-watcher="GridCustomPackage">
                    <div class="col-12 col-flex">
                        <button data-request-url="<?=AppRoute::getRoute(['request', 'customPackage', 'formAdd']);?>"
                                data-trigger-url="<?=AppRoute::getRoute(['request', 'customPackage', 'add']);?>"
                                class="btn btn-primary btn-fa btn-sm"><i class="fa fa-file-import" aria-hidden="true"></i>Neues Custom Package anlegen</button>
                        <div class="container-msg"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="component-msg"></span></div>
                    </div>
                </div>
                <div class="row space-top space-bottom">
                    <div class="col-4"
                         data-grid-component="GridContentBox"
                         data-grid-component-id="GridCustomPackage"
                         data-grid-module="GridListCheckModule,GridTableSearchModule"
                         data-container-request-url="<?=AppRoute::getRoute(['request', 'customPackage', '']);?>"
                         data-container-trigger-url="<?=AppRoute::getRoute(['request', 'customPackage', 'contentBox']);?>"
                         data-grid-watcher="GridCustomPackage"
                         data-grid-element-watcher="GridFormBoxElement_{id}">
                        <div class="header-content-box">
                            <b>Custom Package</b>
                            <div class="container-msg"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="component-msg"></span></div>
                        </div>
                        <div class="container-content-box">
                            <?php include_once $view['customPackageView'];?>
                        </div>
                    </div>
                    <div class="col-8"
                         data-grid-component="GridContentBox"
                         data-grid-component-id="GridCustomElement"
                         data-container-request-url="<?=AppRoute::getRoute(['request', 'customElement', '']);?>"
                         data-container-trigger-url="<?=AppRoute::getRoute(['request', 'customElement', 'contentBox']);?>"
                         data-grid-element-watcher="GridFormBoxElement_{id}">
                        <div class="header-content-box">
                            <b>Custom Package Elemente</b>
                            <div class="container-msg"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="component-msg"></span></div>
                        </div>
                        <div class="container-content-box"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>