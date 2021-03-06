--TEST--
FFI 100: PHP symbols
--SKIPIF--
<?php require_once('skipif.inc'); ?>
<?php
try {
	new FFI("extern void *zend_printf;");
} catch (Throwable $e) {
	die('skip PHP symbols not available');
}
?>
--FILE--
<?php
$zend = new FFI("
	const char *get_zend_version(void);
	//char *get_zend_version(void);
	extern size_t (*zend_printf)(const char *format, ...);

	unsigned long __attribute__((fastcall)) zend_hash_func(const char *str, size_t len);

	void __attribute__((fastcall)) zend_str_tolower(char *str, size_t length);

");
var_dump(trim($zend->get_zend_version()));
//var_dump(trim(FFI::string($zend->get_zend_version())));
var_dump($zend->zend_printf);
var_dump(($zend->zend_printf)("Hello %s!\n", "World"));

var_dump($zend->zend_hash_func("file", strlen("file")));

$str = $zend->new("char[16]");
FFI::memcpy($str, "Hello World!", strlen("Hello World!"));
$zend->zend_str_tolower($str, strlen("Hello World!"));
var_dump(FFI::string($str));

?>
--EXPECTF--
string(%d) "Zend Engine %s"
object(FFI\CData)#%d (1) {
  ["cptr"]=>
  object(FFI\CData)#%d (0) {
  }
}
Hello World!
int(13)
int(%i)
string(12) "hello world!"
