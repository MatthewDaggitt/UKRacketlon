<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

Designer::load("Designer_Content");
Designer::load("Designer_Shortcodes");

$component = new DesignerContent($this, $this->params);
$article = $component->article('article', $this->item, $this->item->params, array('print' => $this->print));
$currentTemplateName = getCurrentTemplateByType($article->isPage ? 'page' : 'post');
?>
<!--TEMPLATE <?php echo $currentTemplateName; ?> /-->
<?php
require_once 'default_template.php';
?>
