<?php
namespace CJDennis\Charset;

interface Iconv {
  public static function convert($string, $to_charset, $replacement);
}
