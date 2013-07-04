<?php
/**
 * INLINE LESS COMPILER AND/OR FILTER
 * Can also be used as a filter in .htaccess as:
 *   RewriteRule ^(.*)\.(css)$ css.php?f=$1.$2 [NC,L]
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

if ('cli' === PHP_SAPI) {
	// called from the command line
	if (is_array($argv) && (count($argv) == 2))
		$_REQUEST['f'] = $argv[1];
}

define('FILE_PREFIX', '_');
define('LESS_EXT', '.less');
define('CSS_EXT', '.css');

function css_compress($buffer)
{
	/**
	 * Derived from David Walsh
	 * @see http://davidwalsh.name/css-compression-php
	 */
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

// echo '/* compiled from css.php */' . PHP_EOL;

$filename = isset($_REQUEST['f']) ? $_REQUEST['f'] : '';
if (!empty($filename)) {

	$lessfile = pathinfo($filename, PATHINFO_FILENAME) . LESS_EXT;
	if (file_exists($lessfile)) {
		/**
		 * Include uses lessphp from 'leaf corcoran' <twitter.com/moonscript>
		 * @see http://leafo.net/lessphp
		 */
		@include('lessc.inc.php');
		$go = class_exists('lessc');
	} else $go = false;

	if ($go) {
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
			echo css_compress(file_get_contents($filename));  // inefficient!
			// readfile($filename);
		} else {
			// ... show not found blank css
			echo '/* File ' . $filename . ' not found */';
		}
	}
} else {
	echo '/* File query missing. Use ?f=filename */';
}
