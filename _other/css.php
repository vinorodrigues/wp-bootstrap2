<?php
/* INLINE LESS COMPILER AND/OR FILTER
 * Can also be used as a filter in .htaccess as:
 *   RewriteRule ^(.*)\.(css)$ css.php?f=$1.$2 [NC,L]
 */

define('FILE_PREFIX', '_');
define('LESS_EXT', '.less');
define('CSS_EXT', '.css');

function css_compress($buffer)
{
	/* Derived from http://davidwalsh.name/css-compression-php */
	return str_replace(': ',':',
		str_replace(';}','}',
		str_replace('; ',';',
		str_replace(' }','}',
		str_replace('{ ','{',
		str_replace(' {','{',
		str_replace(array("\r\n","\r","\n","\t",'  ','   ','    '),"",
		preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*'.'/!','',$buffer))))))));
}

header('Content-Type: text/css');

$filename = isset($_REQUEST['f']) ? $_REQUEST['f'] : '';
if ($filename != '') {
	$lessfile = pathinfo($filename, PATHINFO_FILENAME) . LESS_EXT;

	if (file_exists($lessfile)) {
		$filename = FILE_PREFIX . pathinfo($filename, PATHINFO_FILENAME) . CSS_EXT;
		$go = false;

		if (file_exists($filename)) {
			$lesstime = filemtime($lessfile);
			$filetime = filemtime($filename);
			if ($lesstime > $filetime) $go = true;
		} else {
			$go = true;
		}

		if ($go) {
			include_once '../wrapper/includes/lessc.inc.php';
			$lessc = new lessc($lessfile);
			if (file_exists($filename)) unlink($filename);

			$buffer = /* css_compress( */ $lessc->parse() /* ) */;
			unset($lessc);
			file_put_contents($filename, $buffer);
			echo $buffer;
			unset($buffer);
		} else {
			readfile($filename);
		}

	} else {
		// not a less file ...
		if (file_exists($filename)) {
			// ... so compress the existing .css
			// echo css_compress(file_get_contents($filename));  // inefficient!
			readfile($filename);
		} else {
			// ... show not found blank css
			echo '/* File ' . $filename . ' not found */';
		}
	}
} else {
	echo '/* File query missing. Use ?f=filename */';
}
