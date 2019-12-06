<?php
namespace CJDennis\Charset;

use Normalizer;

class GnuLibiconv implements Iconv {
  use IconvOverrides;

  const UTF_8 = 'UTF-8';

  public static function convert($string, $to_charset, $replacement) {
    return preg_replace_callback('/\X[\x{E0020}-\x{E007F}]*/u', function ($match) use ($to_charset, $replacement) {
      $transliteration_to_charset = "{$to_charset}//IGNORE//TRANSLIT";
      $glyph = iconv(static::UTF_8, $transliteration_to_charset, $match[0]);
      if (iconv($to_charset, static::UTF_8, $glyph) !== $match[0] && array_key_exists($match[0], static::$overrides)) {
        $glyph = static::$overrides[$match[0]];
      }
      else {
        $form_d = Normalizer::normalize($match[0], Normalizer::FORM_D);
        if ($glyph === '') {
          $glyph = iconv(static::UTF_8, $transliteration_to_charset, $form_d);
          if ($glyph === '') {
            $glyph = $replacement;
          }
        }
        elseif (preg_match('/\pL/u', $match[0]) && iconv($to_charset, static::UTF_8, $glyph) !== $match[0]) {  // If the glyph is a letter...
          $glyph = preg_replace('/[\pP\pS]+/u', '', $form_d); // ...then remove all punctuation and symbols
          $glyph = iconv('UTF-8', $transliteration_to_charset, $glyph);
        }
      }
      return $glyph;
    }, $string);
  }
}
