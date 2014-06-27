<?php
/**
 * @license    GPL 3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @author     Yann Pouillon <yann.pouillon@gmail.com>
 */

if ( !defined('DOKU_INC') ) {
  define('DOKU_INC',dirname(__FILE__).'/../../../');
}
define('NOSESSION',true);
require_once(DOKU_INC.'inc/init.php');

// Let the syntax plugin do the work
$data = $_REQUEST;
$plugin = plugin_load('syntax', 'dataplot');
$cache  = $plugin->_imgfile($data);
if(!$cache) _fail();

header('Content-Type: image/png;');
header('Expires: '.gmdate("D, d M Y H:i:s", time()+max($conf['cachetime'], 3600)).' GMT');
header('Cache-Control: public, proxy-revalidate, no-transform, max-age='.max($conf['cachetime'], 3600));
header('Pragma: public');
http_conditionalRequest($time);
echo io_readFile($cache,false);

function _fail() {
  header("HTTP/1.0 404 Not Found");
  header('Content-Type: image/png');
  echo io_readFile('error.png', false);
  exit;
}
