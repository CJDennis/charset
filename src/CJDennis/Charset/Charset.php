<?php
namespace CJDennis\Charset;

class Charset {
  /** @var Iconv */
  protected static $iconv_library;

  public static function convert($string, $to_charset = 'ASCII', $replacement = '?') {
    if (static::$iconv_library === null) {
      /** @noinspection PhpUnhandledExceptionInspection */
      static::set_iconv_library();
    }
    return call_user_func([static::$iconv_library, 'convert'], $string, $to_charset, $replacement);
  }

  /** @throws CharsetException */
  protected static function set_iconv_library() {
    switch (trim(static::get_iconv_implementation(), '"')) {
      case 'libiconv': {
        /** @var GnuLibiconv */
        static::$iconv_library = __NAMESPACE__ . '\\' . 'GnuLibiconv';
        break;
      }
      case 'BSD iconv': {
        static::$iconv_library = __NAMESPACE__ . '\\' . 'Bsd';
        break;
      }
      case 'glibc': {
        /** @var Glibc */
        static::$iconv_library = __NAMESPACE__ . '\\' . 'Glibc';
        break;
      }
      case 'IBM iconv': {
        static::$iconv_library = __NAMESPACE__ . '\\' . 'Ibm';
        break;
      }
      default: {
        throw new CharsetException('Unknown iconv library');
      }
    }
  }

  protected static function get_iconv_implementation() {
    return ICONV_IMPL;
  }
}
