<link href="<?php echo ROOT ?>style/script.style.css" rel="stylesheet" type="text/css" />

<?php if($getController == 'gallery') { ?>

<link href="<?php echo ROOT ?>style/gallery.style.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]> <link href="<?php echo ROOT ?>style/lteIE7.style.css" rel="stylesheet" type="text/css" /> <![endif]-->
<link href="<?php echo ROOT ?>style/gallery.dyn.style.php" rel="stylesheet" type="text/css" />

<?php } elseif($getController == 'admin') { ?>

<link href="<?php echo ROOT ?>style/admin.style.css" rel="stylesheet" type="text/css" />

<?php } else { ?>

<link href="<?php echo ROOT ?>style/default.style.css" rel="stylesheet" type="text/css" />

<?php } ?>