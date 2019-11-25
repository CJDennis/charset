<?php
namespace CJDennis\Charset;

class Charset {
  public static function convert($string, $to_charset = 'ASCII') {
    return iconv('UTF-8', "{$to_charset}//TRANSLIT", $string);
  }
}
