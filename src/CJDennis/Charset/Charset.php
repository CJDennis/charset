<?php
namespace CJDennis\Charset;

class Charset {
  public static function convert($string) {
    return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
  }
}
