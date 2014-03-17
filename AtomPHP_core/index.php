<?php
/**
  * @Category   AtomPHP
  * @Package    me.7in0.atomphp
  * @Author     7IN0SAN9 <me@7in0.me>
  * @License    CC BY-ND 4.0
  * @Version    1.3.1
  * @Website    https://7in0.me/studio/projects/AtomPHP
  */

// Starting session.
session_start ();
// Setting charset.
header ( 'content-type:text/html; charset=utf-8' );

// Requiring essential files.
require_once 'config.php';
require_once 'function.core.inc.php';

// Create an instance of Class atomPHP.
$core = new atomPHP ( $option );

// Get parameters for applaction
$appStr = empty ( $_GET ['app'] ) ? 'index' : $_GET ['app']; // Get applaction name
$appMethod = empty ( $_GET ['act'] ) ? 'index' : $_GET ['act']; // Get menthod name
                                                                
// Get parameters for controller
$appPara = $_GET ['p'];
$core->addVariable ( $appPara );
$postPara = ( object ) $_POST;
$core->addVariable ( $postPara, 'POST' );

// Load the applaction
$appName = $appStr . 'Controller';
$appFile = 'controller/' . $appName . '.php';

if (! file_exists ( $appFile ))
    $core->err ( '102', $appFile );

require_once $appFile;

if (! class_exists ( $appName ))
    $core->err ( '104', $appFile );

$controller = new $appName ( $core );

if (! method_exists ( $appName, $appMethod ))
    $core->err ( '106', $appName . '->' . $appMethod );

$controller->$appMethod (); // Run the applaction

?>