<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';
?>
<!--TEMPLATE <?php echo getCurrentTemplateByType('products'); ?> /-->
<?php
JHTML::_( 'behavior.modal' );
require_once 'default_template.php';
?>
