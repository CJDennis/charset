<?php
namespace CJDennis\Charset;

use Normalizer;

class GnuLibiconv implements Iconv {
  use IconvOverrides;

  public static function convert($string, $to_charset, $replacement) {
    return preg_replace_callback('/\X[\x{E0020}-\x{E007F}]*/u', function ($match) use ($to_charset, $replacement) {
      $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $match[0]);
      if (iconv($to_charset, 'UTF-8', $glyph) !== $match[0] && array_key_exists($match[0], static::$overrides)) {
        $glyph = static::$overrides[$match[0]];
      }
      elseif ($glyph === '') {
        $glyph = Normalizer::normalize($match[0], Normalizer::FORM_D);
        $glyph = iconv('UTF-8', "{$to_charset}//IGNORE//TRANSLIT", $glyph);
        if ($glyph === '') {
          $glyph = $replacement;
        }
      }
      elseif (preg_match('/\w/', $glyph)) {        // If the text contains any letters...
        $glyph = preg_replace('/\W+/', '', $glyph); // ...then remove all non-letters
      }
      return $glyph;
    }, $string);
  }
}
