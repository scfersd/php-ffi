--TEST--
FFI 011: cast()
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
$a = FFI::new("uint8_t[4]");
$a[0] = 255;
$a[1] = 255;
var_dump(FFI::cast("uint16_t[2]", $a));
?>
--EXPECTF--
object(FFI\CData)#%d (2) {
  [0]=>
  int(65535)
  [1]=>
  int(0)
}
