<?php
/** @noinspection PhpUnused */
namespace CJDennis\Charset;

trait CharsetTestCommon {
  // tests
  public function testShouldConvertCurlyUnicodeQuotesToStraightASCIIQuotes() {
    $this->assertSame(
      CharsetTestCharacters::ASCII_QUOTATION_MARK .
      CharsetTestCharacters::ASCII_APOSTROPHE .
      CharsetTestCharacters::ASCII_APOSTROPHE .
      CharsetTestCharacters::ASCII_QUOTATION_MARK,
      Charset::convert(
        CharsetTestCharacters::UTF8_LEFT_DOUBLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_LEFT_SINGLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_RIGHT_SINGLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_RIGHT_DOUBLE_QUOTATION_MARK)
    );
  }

  public function testShouldConvertCurlyUnicodeQuotesToCurlyCP1252Quotes() {
    $this->assertSame(
      CharsetTestCharacters::CP1252_LEFT_DOUBLE_QUOTATION_MARK .
      CharsetTestCharacters::CP1252_LEFT_SINGLE_QUOTATION_MARK .
      CharsetTestCharacters::CP1252_RIGHT_SINGLE_QUOTATION_MARK .
      CharsetTestCharacters::CP1252_RIGHT_DOUBLE_QUOTATION_MARK,
      Charset::convert(
        CharsetTestCharacters::UTF8_LEFT_DOUBLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_LEFT_SINGLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_RIGHT_SINGLE_QUOTATION_MARK .
        CharsetTestCharacters::UTF8_RIGHT_DOUBLE_QUOTATION_MARK,
        'CP1252')
    );
  }
}
