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
    <div class="task content-menu-data active" data-grid-name-space="Profil">
        <div class="task-content">
            <div class="grid-container grid-content">
                <div class="row">
                    <div class="col-12" data-grid-component="GridUpdateProfil">
                        <div class="row space-bottom">
                            <div class="col-12" >
                                <div class="label-container"><label class="title" for="">Profildaten verändern</label></div>
                                <table class="formTable">
                                    <tr class="row-lbl">
                                        <th>Username</th>
                                        <td>
                                            <input data-required="required" type="hidden" name="id" value="<?=$view["user"]["id"];?>" title="User-Id">
                                            <input data-required="required" type="text" name="name" value="<?=$view["user"]["name"];?>" data-cache-value="<?=$view["user"]["name"];?>" title="Username" readonly>
                                        </td>
                                    </tr>
                                    <tr class="row-lbl">
                                        <th>Mitarbeiter</th>
                                        <td><input data-required="required" type="text" name="realname" value="<?=$view["user"]["realname"];?>" data-cache-value="<?=$view["user"]["realname"];?>" title="Mitarbeiter"></td>
                                    </tr>
                                    <tr class="row-lbl">
                                        <th>Email-Adresse</th>
                                        <td><input data-required="required" type="text" name="email" value="<?=$view["user"]["email"];?>" data-cache-value="<?=$view["user"]["email"];?>" title="Email-Adresse"></td>
                                    </tr>
                                    <tr class="row-lbl">
                                        <th>Telefonnummer</th>
                                        <td><input data-required="required" type="text" name="phone" value="<?=$view["user"]["phone"];?>" data-cache-value="<?=$view["user"]["phone"];?>" title="Telefonnummer"></td>
                                    </tr>
                                    <tr class="row-lbl">
                                        <th>Fax</th>
                                        <td><input type="text" name="fax" value="<?=$view["user"]["fax"];?>" data-cache-value="<?=$view["user"]["fax"];?>" title="Fax"></td>
                                    </tr>
                                </table>
                                <div class="container-msg"><span class="component-msg"></span></div>
                                <button data-request-url="<?=AppRoute::getRoute(['request', 'user', 'updateProfil']);?>"
                                        class="btn-primary btn-fa"><i class="fa fa-file-import" aria-hidden="true"></i>Profil speichern</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>