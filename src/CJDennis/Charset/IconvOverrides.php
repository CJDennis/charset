<?php
namespace CJDennis\Charset;

trait IconvOverrides {
  protected static $overrides = [
    '£' => 'L',
    '¥' => 'Y',
  ];
}
