<?php
namespace CJDennis\Charset;

class Glibc implements Iconv {
  public static function convert($string, $to_charset, $replacement) {
    $file_handle = tmpfile();
    $path = stream_get_meta_data($file_handle)['uri'];

    $to_charset = static::escape_bash($to_charset);
    $path = static::escape_bash($path);

    return preg_replace_callback('/\X/u', function ($match) use ($file_handle, $path, $to_charset, $replacement) {
      ftruncate($file_handle, 0);
      fseek($file_handle, 0);
      fwrite($file_handle, $match[0]);
      fflush($file_handle);

      $glyph = system("iconv -c -f UTF-8 -t {$to_charset}//TRANSLIT {$path}", $return_var);
      if ($glyph === false) {
        $glyph = $replacement;
      }

      return $glyph;
    }, $string);
  }

  protected static function escape_bash($string) {
    $string = str_replace("'", "'\\''", $string);
    return $string;
  }
}
