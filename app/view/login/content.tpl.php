
<div class="grid-container">
    <div class="row space-bottom space-top"><div class="col-12 col-page-title"></div></div>
    <?php 
    if (empty($view['pageAction'])) {
        include_once 'login.tpl.php';
    } else {
        include_once $view['pageAction'].'.tpl.php';
    }
    ?>
</div>


