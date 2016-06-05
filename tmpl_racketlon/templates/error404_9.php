<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta charset="utf-8" />
    <?php
        $base = $document->getBase();
        if (!empty($base)) {
            echo '<base href="' . $base . '" />';
            $document->setBase('');
        }
    ?>
       <?php 
	$app = JFactory::getApplication();
    $tplparams	= $app->getTemplate(true)->params;
	$close_slideshow = htmlspecialchars($tplparams->get('close_slideshow'));
	$close_text = htmlspecialchars($tplparams->get('close_text'));
	$fc = htmlspecialchars($tplparams->get('fc'));
	$tc = htmlspecialchars($tplparams->get('tc'));
	$gc = htmlspecialchars($tplparams->get('gc'));
	$pc = htmlspecialchars($tplparams->get('pc'));
	$allicon = htmlspecialchars($tplparams->get('allicon'));
    $ac = htmlspecialchars($tplparams->get('ac'));
	$close_box = htmlspecialchars($tplparams->get('close_box'));
	

	?>
  <link href="<?php echo $document->params->get('fav'); ?>" rel="icon" type="image/x-icon" />
    <script>
    var themeHasJQuery = !!window.jQuery;
</script>
<script src="<?php echo addThemeVersion($document->templateUrl . '/jquery.js'); ?>"></script>
<script>
    window._$ = jQuery.noConflict(themeHasJQuery);
</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="<?php echo addThemeVersion($document->templateUrl . '/bootstrap.min.js'); ?>"></script>
    
    <?php echo $document->head; ?>
    <?php if ($GLOBALS['theme_settings']['is_preview'] || !file_exists($themeDir . '/css/bootstrap.min.css')) : ?>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/bootstrap.css'); ?>" media="screen" />
    <?php else : ?>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/bootstrap.min.css'); ?>" media="screen" />
    <?php endif; ?>
    <?php if ($GLOBALS['theme_settings']['is_preview'] || !file_exists($themeDir . '/css/template.min.css')) : ?>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/template.css'); ?>" media="screen" />
    <?php else : ?>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/template.min.css'); ?>" media="screen" />
    <?php endif; ?>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/template.ie.css'); ?>" media="screen"/>
    <![endif]-->
    <?php if(('edit' == JRequest::getVar('layout') || 'form' == JRequest::getVar('view')) ||
        ('com_config' == JRequest::getVar('option') || 'config.display.modules' == JRequest::getVar('controller'))) : ?>
    <link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/media.css'); ?>" media="screen" />
    <script src="<?php echo addThemeVersion($document->templateUrl . '/js/template.js'); ?>"></script>
    <?php endif; ?>
    <script src="<?php echo addThemeVersion($document->templateUrl . '/script.js'); ?>"></script>
    <!--[if lte IE 9]>
    <script src="<?php echo addThemeVersion($document->templateUrl . '/script.ie.js'); ?>"></script>
    <![endif]-->
    
</head>
<body class=" bootstrap bd-body-9 bd-pagebackground">
    <div class=" bd-stretchtobottom-5 bd-stretch-to-bottom" data-control-selector=".bd-sheet-9"><div class="bd-sheetstyles bd-sheet-9 ">
    <div class="bd-container-inner">
        <?php
// set messages
$title   = $this->title;

$code = 'Code';
$msg = 'Message';

if (method_exists($this->error, 'get' . $code))
$error = $this->error->{'get' . $code}();
else
$error = $this->error->get(strtolower($code));

if (method_exists($this->error, 'get' . $msg))
$message = $this->error->{'get' . $msg}();
else
$message = $this->error->get(strtolower($msg));


?>

<div class=" bd-text404-41 bd-tagstyles shape-only">
<?php  echo $error . ' - ' . $message ?>
</div>
    </div>
</div></div>
</body>
</html>