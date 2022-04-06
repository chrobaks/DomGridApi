<?php $view = $view ?? [];?>
<div class="grid-container">
    <div class="row">
        <div class="col-12 col-page-title">
            <ul class="content-menu">
                <li class="content-menu-item active"><a><i class="fa fa-file-excel" aria-hidden="true"></i><?=$view["pageTitle"];?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="task-container">
    <div class="task content-menu-data active" data-grid-name-space="UserList">
        <div class="task-content">
            <div class="grid-container grid-content">
                <div class="row">
                    <div class="col-12" data-grid-component="GridUserList" data-container-url="<?=AppRoute::getRoute(['request', 'user', 'formTblUser']);?>">
                        <div class="row space-bottom">
                            <div class="col-12" >
                                <div class="wrapper-container">
                                    <div class="wrapper-exprList row-size-50">
                                        <div class="label-container"><label class="title" for="">Benutzer-Daten verändern / löschen </label></div>
                                        <table class="formTable">
                                            <thead>
                                                <tr class="row-lbl">
                                                    <th>ID</th>
                                                    <th>Username</th>
                                                    <th>Rolle</th>
                                                    <th>Email</th>
                                                    <th>Mitarbeitername</th>
                                                    <th>Aktion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php require_once VIEW_PATH.'request/modalForm/formTblUser.tpl.php';?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="container-msg"><span class="component-msg"></span></div>
                                <button data-request-url="<?=AppRoute::getRoute(['request', 'user', 'formAddUser']);?>"
                                        data-trigger-url="<?=AppRoute::getRoute(['request', 'user', 'addUser']);?>"
                                        class="btn-primary btn-fa"><i class="fa fa-file-import" aria-hidden="true"></i>Neuen Benutzer anlegen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
