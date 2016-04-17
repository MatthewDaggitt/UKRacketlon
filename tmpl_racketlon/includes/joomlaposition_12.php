<?php
function joomlaposition_12() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('banner-1') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('banner-1')) : ?>

    <?php if ($isPreview && !$view->containsModules('banner-1')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-12 clearfix" <?php echo buildDataPositionAttr('banner-1'); ?>>
        <?php echo $view->position('banner-1', 'block%joomlaposition_block_12', '12'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('banner-1')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}