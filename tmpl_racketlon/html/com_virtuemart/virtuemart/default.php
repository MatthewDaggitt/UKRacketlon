<?php
defined('_JEXEC') or die;
?>

<?php JHTML::_( 'behavior.modal' ); ?>
<!-- Vendor Store Description -->
<?php if (!empty($this->vendor->vendor_store_desc) and VmConfig::get('show_store_desc', 1)) : ?>
    <div class="vendor-store-desc">
        <?php echo $this->vendor->vendor_store_desc; ?>
    </div>
<?php endif; ?>

<!-- Load categories from front_categories if exist -->
<?php if ($this->categories and VmConfig::get('show_categories', 1)) : ?>
    <?php echo $this->loadTemplate('categories'); ?>
<?php endif; ?>

<!-- Show template for : topten,Featured, Latest Products if selected in config BE -->
<?php if (!empty($this->products) ) : ?>
	<?php echo $this->loadTemplate('products'); ?>
<?php endif; ?>
