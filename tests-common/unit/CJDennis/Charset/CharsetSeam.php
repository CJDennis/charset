<?php
namespace CJDennis\Charset;

class CharsetSeam extends Charset {
  protected static $iconv_implementation;

  public static function unset_iconv_library() {
    static::$iconv_library = null;
  }

  public static function unset_iconv_implementation() {
    static::$iconv_implementation = null;
  }

  public static function set_iconv_implementation($string) {
    static::$iconv_implementation = $string;
    /** @noinspection PhpUnhandledExceptionInspection */
    static::set_iconv_library();
  }

  public static function get_iconv_library() {
    return static::$iconv_library;
  }

  protected static function get_iconv_implementation() {
    return static::$iconv_implementation === null? parent::get_iconv_implementation(): static::$iconv_implementation;
  }
}
