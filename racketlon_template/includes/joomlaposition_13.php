<?php
function joomlaposition_13() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('topbanner-2') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('topbanner-2')) : ?>

    <?php if ($isPreview && !$view->containsModules('topbanner-2')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-13 clearfix" <?php echo buildDataPositionAttr('topbanner-2'); ?>>
        <?php echo $view->position('topbanner-2', 'block%joomlaposition_block_13', '13'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('topbanner-2')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}