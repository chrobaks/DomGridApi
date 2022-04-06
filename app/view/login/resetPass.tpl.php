

    <?php if(!isset($view['resetOk'])):?>

    <form action="<?=AppTpl::route(['login','resetPass']);?>" class="needs-validation" method="post">
        <div class="row bottom-buffer">
            <div class="col-2"></div>
            <div class="col-6">
                Bitte gib deine Emailadresse ein und klicke auf <span class="text-green">Neues Passwort erstellen</span> und<br>
                öffne dein Email-Postfach und folge der Anweisung in der Email, die wir dir geschickt haben.
            </div>
        </div>
        <div class="row bottom-buffer">
            <div class="col-2"><label for="email">Email-Adesse:</label></div>
            <div class="col-6">
                <input type="email" class="form-control" id="email" placeholder="Deine Email@Adressse" name="email" value="" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Deine Email-Adresse ist nicht korrekt!</div>
            </div>
        </div>
       
        <div class="row bottom-buffer">
            <div class="col-2"></div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in-alt"></i> Neues Passwort erstellen</button>
            </div>
        </div>
    </form> 
    
    <?php endif;?>
    