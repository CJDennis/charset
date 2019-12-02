<?php
namespace CJDennis\Charset;

use Normalizer;

class GnuLibiconv implements Iconv {
  public static function convert($string, $to_charset, $replacement) {
    return preg_replace_callback('/\X[\x{E0020}-\x{E007F}]*/u', function ($match) use ($to_charset, $replacement) {
      $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $match[0]);
      if ($glyph === '') {
        $glyph = Normalizer::normalize($match[0], Normalizer::FORM_D);
        $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $glyph);
        if ($glyph === '') {
          $glyph = $replacement;
        }
      }
      return $glyph;
    }, $string);
  }
}
