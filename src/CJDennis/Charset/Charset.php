<?php
namespace CJDennis\Charset;

class Charset {
  public static function convert($string, $to_charset = 'ASCII') {
    return preg_replace_callback('/\X/u', function ($match) use ($to_charset) {
      $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $match[0]);
      // The documentation says that iconv() returns false on failure but it returns either '' or false depending on the library
      if ($glyph === false || $glyph === '') {
        $glyph = '?';
      }
      return $glyph;
    }, $string);
  }
}
