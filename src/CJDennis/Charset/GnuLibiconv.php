<?php
namespace CJDennis\Charset;

class GnuLibiconv implements Iconv {
  public static function convert($string, $to_charset, $replacement) {
    return preg_replace_callback('/\X/u', function ($match) use ($to_charset, $replacement) {
      $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $match[0]);
      if ($glyph === '') {
        $glyph = $replacement;
      }
      return $glyph;
    }, $string);
  }
}
