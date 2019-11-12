<?php

/**
 * autoloader for namespaces
 * @since 1.0.0
*/

spl_autoload_register('wspp_auto_loader');

function wspp_auto_loader($class_name) {

  // if the namespace comes from outside then duck out
  if(strpos( $class_name, 'WSPP' ) === FALSE) return;


  // includes all file
  $namespace_arr = explode("\\", $class_name);
  array_shift($namespace_arr);
  $file_path = implode(DIRECTORY_SEPARATOR, $namespace_arr);
  include_once WSPP_BASE_PATH . 'inc/classes/' . $file_path . '.php';

}
