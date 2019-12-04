<?php
namespace CJDennis\Charset;

class Glibc implements Iconv {
  use IconvOverrides;

  const UTF_8 = 'UTF-8';

  const UTF8_QUESTION_MARK = '?';
  const UTF8_INVERTED_QUESTION_MARK = "\xC2\xBF";
  const UTF8_SMALL_QUESTION_MARK = "\xEF\xB9\x96";
  const UTF8_FULLWIDTH_QUESTION_MARK = "\xEF\xBC\x9F";

  public static function convert($string, $to_charset, $replacement) {
    return preg_replace_callback('/\X/u', function ($match) use ($to_charset, $replacement) {
      $glyph = iconv(static::UTF_8, "{$to_charset}//TRANSLIT", $match[0]);
      if (iconv($to_charset, static::UTF_8, $glyph) !== $match[0] && array_key_exists($match[0], static::$overrides)) {
        $glyph = static::$overrides[$match[0]];
      }
      elseif ($glyph === false) {
        $glyph = $replacement;
      }
      elseif ($glyph === '?' && !preg_match("/[" . join('', [
            static::UTF8_QUESTION_MARK,
            static::UTF8_INVERTED_QUESTION_MARK,
            static::UTF8_SMALL_QUESTION_MARK,
            static::UTF8_FULLWIDTH_QUESTION_MARK,
          ]) . "]/u", $match[0])) {
        $glyph = $replacement;
      }

      return $glyph;
    }, $string);
  }
}
