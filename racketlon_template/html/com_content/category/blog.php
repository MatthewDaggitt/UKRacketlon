<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';

Designer::load("Designer_Content");
?>
<!--TEMPLATE <?php echo getCurrentTemplateByType('blog'); ?> /-->
<?php
require_once 'blog_template.php';
?>
