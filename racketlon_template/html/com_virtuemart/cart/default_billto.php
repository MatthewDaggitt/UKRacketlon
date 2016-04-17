<?php
defined('_JEXEC') or die;
?>

<?php ob_start(); ?>
<div class="output-billto">
    <?php foreach ($this->cart->BTaddress['fields'] as $item) : ?>
        <?php if (!empty($item['value'])) : ?>
            <?php if ($item['name'] === 'agreed') : ?>
                <?php $item['value'] = ($item['value'] === 0) ? JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES'); ?>
            <?php endif; ?>
            <!-- span class="titles"><?php echo $item['title'] ?></span -->
            <span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
            <?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') : ?>
                <br class="clear"/>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>
<div class=" bd-container-42 bd-tagstyles">
<a class=" bd-button" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>"  >
    <?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
</a></div>
<input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
<?php 
    echo renderTemplateFromIncludes($this->blockFuncName, array(JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'),  ob_get_clean())); 
?>
