<?php
/* INLINE XSL FILTER & LOADER
 * (Translates './' to fully qualified path.)
 * Can also be used as a filter in .htaccess as:
 *   RewriteRule ^(.*)\.(xsl)$ xsl.php?f=$1.$2 [NC,L]
 */

if ('cli' === PHP_SAPI) {
	// called from the command line
	if (is_array($argv) && (count($argv) == 2))
		$_REQUEST['f'] = $argv[1];
}

header('Content-Type: text/xsl; charset=utf-8');

$filename = isset($_REQUEST['f']) ? $_REQUEST['f'] : '';
if ($filename != '') {
	if (file_exists($filename)) {
		$path = rtrim(dirname( $_SERVER['PHP_SELF'] ), '/') . '/';
		$content = file_get_contents($filename);
		$content = str_replace('../', '###', $content);
		$content = str_replace('./', $path, $content);
		$content = str_replace('###', '../', $content);
		echo $content;
	} else {
		echo '<!-- File ' . $filename . ' not found -->';
	}
} else {
	echo PHP_EOL . '<!-- File query missing. Use ?f=filename -->';
}
