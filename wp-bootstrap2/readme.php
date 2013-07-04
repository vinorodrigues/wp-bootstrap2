<?php
/**
 * README.md File shower-er
 *
 * Copyleft (c) 2013 Vino Rodrigues
 *
 * This work is Public Domain.
 *
 * **********************************************************************
 *   This code is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * **********************************************************************
 */

if (isset($_REQUEST['f'])) {
	$filename = $_REQUEST['f'];
	if (!file_exists($filename)) $filename = '';
} else $filename = '';

if (empty($filename)) {
	if (file_exists('README.md')) $filename = 'README.md';
	else if (file_exists('README.txt')) $filename = 'README.txt';
}

if (empty($filename))
	header("HTTP/1.0 404 Not Found", true, 404);

/**
 * PHP Markdown
 *
 * Please use the Nijiko Yonskai <nexua.org> version
 * @see http://github.com/Nijikokun/Markdown
 */
@include('markdown.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <style>
    body { padding-top: 60px; }
    h1 { padding-bottom: 0.125em; border-bottom: 3px solid #DDD;}
    h2 { padding-bottom: 0.125em; border-bottom: 2px solid #CCC;}
    h3 { padding-bottom: 0.125em; border-bottom: 1px solid #BBB;}
  </style>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <span class="brand"><i class="icon-eye-open"></i> <?php echo $filename; ?></span>
    </div>
  </div>
</div>	
<div class="container-fluid">
<?php

if (empty($filename)) {
	?><div class="alert alert-error"><h4>File not Found</h4></div><?php
} else {
	$content = file_get_contents($filename);

	if ( class_exists('Markdown') ) {
		$md = new Markdown();
		echo $md->transform($content);
	} else {
		echo '<!-- Markdown not found -->' . PHP_EOL;
		?><pre style="border:none;background:transparent"><?php
		echo $content;
		?></pre><?php
	}
}
?>
</div></body>
</html>
<?php

/* eof */
