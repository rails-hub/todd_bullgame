<div class="fact-container" id="facts-<?= $category->id ?>" style="display: block">
    <div id="nav" style=" position:static;">
        <div class="left-text">
            <?= HTML::anchor("#categories", "< back", array("id" => "backToCategory")) ?>
        </div>
        <div class="mid-text" style="margin-left:0; width: 72%; text-align: center">
            <?= $category->title ?> facts
        </div>
        <div class="text-right" id="text-right-<?= $category->id ?>">
            score: <span class="t-score"><?= $user->score == null ? 0 : $user->score ?></span>
        </div>

    </div>
    <div class="black_overlay">
        <div class="wrapper-popup" style="display: none" id="wrap-<?= $category->id ?>">
            <div class="popup">
                <div class="close">
                    <?= HTML::image("media/img/close.png", array("alt" => "")) ?>
                </div>
                <div class="red-text">
                    the rules

                </div>
                <div class="popup-para">
                    Six facts will appear. Stop the bull by clicking the false ones. Don't fight the
                    truth!
                </div>
            </div>
        </div>
    </div>

    <div class="bulls-wrapper" id="bulls-wrapper_<?= $category->id ?>">
        <? $falseCount = 0 ?>
        <? $trueCount = 0 ?>
        <? $factCount = 1 ?>
        <?= Form::hidden("options_{$category->id}", 0, array("id" => "options_{$category->id}", "class" => "c_options")) ?>
        <?= Form::hidden("t_traveled_{$category->id}", 0, array("id" => "t_traveled_{$category->id}", "class" => "t_traveled")) ?>
        <?= Form::hidden("f_traveled_{$category->id}", 0, array("id" => "f_traveled_{$category->id}", "class" => "f_traveled")) ?>
        <?= Form::hidden("f_c_{$category->id}", 0, array("id" => "f_c_{$category->id}")) ?>
        <?= Form::hidden("t_c_{$category->id}", 0, array("id" => "t_c_{$category->id}")) ?>
        <?= Form::hidden("false_c_{$category->id}", 0, array("id" => "false_c_{$category->id}")) ?>
        <? foreach ($facts as $fact) : ?>
            <? if (!$fact->is_true) : ?>
                <? $falseCount++ ?>
                <script type="text/javascript">
                    var iid = <?= $category->id?>;
                    var ival = parseInt($("#f_c_" + iid).val());
                    ival = ival + parseInt(<?= $point->guess_right ?>);
                    $("#f_c_" + iid).val(ival);
                    var eva = parseInt(<?= $falseCount ?>);
                    $("#false_c_" + iid).val(eva);
                </script>
            <? else : ?>
            <? $trueCount++ ?>
                <script type="text/javascript">
                    var tid = <?= $category->id?>;
                    var tval = parseInt(<?= $trueCount ?>);
                    $("#t_c_" + tid).val(tval);
                </script>
            <? endif; ?>
            <? if ($factCount == 1 || $factCount % 3 == 1) : ?>
                <div class="bulls-row">
            <? endif; ?>
            <div class="bulls-click bull_class bull<?= $factCount ?>"
                 id='<?= $fact->is_true ? "{$fact->id}_ts" : "{$fact->id}_fs" ?>'
                 onclick="check_fact(this)">
                <div id="<?= $fact->id ?>_<?= $category->id ?>"
                     class="bulls-text text<?= $factCount ?>"><?= $fact->title ?>
                </div>
            </div>
            <div class="pow-go pows-<?= $factCount ?>" id="pow-<?= $fact->id ?>" style="display: none">
                <div class="row-pts green" style="display: none">+10 Points</div>
                <div class="row-pts red-pow" style="display: none">-10 Points</div>
            </div>


            <? if ($factCount % 3 == 0) : ?>
                </div>
            <? endif; ?>
            <? $factCount++ ?>
        <? endforeach; ?>
    </div>

</div>
<div id="bulls-bottom-row" style="display: none">
    <div class="bulls-bottom-row">
        <div class="baby-bull">
            <?= HTML::image("media/img/baby-bull.png", array("alt" => "", "id" => "baby-bull-img", "class" => "flipImage")) ?>
        </div>

    </div>
    <div class="flag-narrow">
        <?= HTML::image("media/img/flag-narrow.png", array("alt" => "")) ?>
    </div>
</div>


<script type="text/javascript">
    var score = $('.t-score').html();
    $('#bl_po').val(parseInt(score));
</script>