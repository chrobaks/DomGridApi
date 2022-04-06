<?php $view = $view ?? []; ?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title><?=$view["title"];?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?=AppRoute::getRoute('').IMAGE_URL;?>favicon.ico">
        
        <?=AppTpl::renderAppCss(["all.min","checkmark","app","domgrid","gridDateTimePicker"]);?>
        <?=AppTpl::renderAppJs([
            [
                "url" => AppRoute::getRoute('').JS_URL.'app/core/',
                "dir" => array_diff(scandir(JS_PATH.'app/core'.DIRECTORY_SEPARATOR), ['..', '.']),
                "requiredFirst" => ['GridReady.js','GridUi.js','GridAjax.js']
            ],
        ]);?>

        <script>
            /**
             *-------------------------------------------
             * Create DomGrid instance GridStage
             *-------------------------------------------
             **/
            let GridStage = {};
            /**
             *-------------------------------------------
             * Initialize DomGrid instance GridStage
             *-------------------------------------------
             **/
            GridReady(() => {
                GridStage = new DomGrid({containerId : "grid-container", scriptPath : "<?=AppRoute::getRoute('').JS_URL.'app/';?>"});
            });
        </script>
    </head>
    <body id="grid-container" data-grid-module="GridAppLang,GridDateTimePicker" data-grid-route="<?=AppRoute::getRouteController();?>">
        <div class="navi">
            <div class="navi-logo">
                <div class="row">
                    <div class="navi-img"></div>
                    <div class="navi-title"><span class="title-pre-fix">netCoDev / </span><?=$view["title"];?></div>
                </div>
            </div>
            <div id="appMenu" class="navi-menu">
                <div class="navi-menu-container">
                    <?php if(AppSession::isUsersession()):?>
                        <div class="dropdown flt-right">
                            <div class="dropdown-label"><i class="fa fa-user"></i><?=AppSession::getValue('user');?></div>
                            <div class="dropdown-items">
                                <div class="dropdown-item"><a href="<?=$view['url']."logout";?>"><i class="fa fa-sign-out-alt"></i>Logout</a></div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php include_once $view['page'].'/content.tpl.php';?>
        <div data-grid-name-space="SideNavi"
             data-grid-component="GridSidePanel" class="grid-sidenavi right">
            <ul class="sidenavi-menu">
                <li class="btn-slide"><a class="btn-slide-item"><i class="fa fa-info-circle"></i></a></li>
                <li class="btn-slide"><a class="btn-slide-item"><i class="fa fa-at"></i></a></li>
            </ul>
            <div class="sidenavi-content">
                <div class="content-page"
                     data-grid-component="GridDevConsole"
                     data-grid-component-id="GridDevConsole">
                    <b data-translate="example_side_panel_header_1">DomGrid Console</b><br>
                    <p data-translate="example_side_panel_text_1"><input class="inpt-console"></p>
                    <p data-translate="example_side_panel_text_2">Mit einem Klick auf ein Icon wechselt man die Ansicht. Wenn man noch einmal auf dasselbe Icon klickt, dann schliesst sich die Ansicht.</p>
                </div>
                <div class="content-page">
                    <b data-translate="example_side_panel_header_2">Kontakt</b><br>
                    <p data-translate="example_side_panel_text_3">Hier könnte ein Kontaktformular angezeigt werden.</p>
                </div>
            </div>
        </div>
    </body>
</html>