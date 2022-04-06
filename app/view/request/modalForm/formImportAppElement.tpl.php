<?php $view = $view ?? []; ?>
<?php if(empty($view["forms"])):?>
    <tbody><tr>
        <td class="table-message"><i class="fa fa-info-circle"></i> Keine Daten vorhanden!</td>
    </tr></tbody>
<?php else:?>
    <thead>
    <?php foreach ($view["forms"] as $forms):?>
        <tr>
            <th class="static-cell"><input type="checkbox" class="check-all"></th>
            <?php foreach ($forms as $key => $val):?>
                <?php if(isset($val['type']) && $val['type'] !== 'hidden' || !isset($val['type']) && isset($val['label'])):?>
                    <th class="static-cell"><?=$val['label'];?></th>
                <?php endif;?>
            <?php endforeach;?>
        </tr>
        <?php break;?>
    <?php endforeach;?>
    </thead>
    <tbody>
    <?php foreach ($view["forms"] as $forms):?>
        <tr class="row-data">
            <td class="static-cell">
                <?php foreach ($forms as $key => $val):?>
                    <?php if(isset($val['type']) && $val['type'] === 'hidden'):?>
                        <?=AppTpl::renderFormElement($val);?>
                    <?php endif;?>
                <?php endforeach;?>
                <input type="checkbox" class="check-item">
            </td>
            <?php foreach ($forms as $key => $val):?>
                <?php if(isset($val['type']) && $val['type'] !== 'hidden' || !isset($val['type']) && isset($val['label'])):?>
                    <td class="txtCenter" data-search-column="<?=$val['name'];?>"><div><?=AppTpl::renderFormElement($val);?></div></td>
                <?php endif;?>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
    </tbody>
<?php endif;?>