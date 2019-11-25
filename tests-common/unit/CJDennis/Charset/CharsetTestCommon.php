<?php
/** @noinspection PhpUnused */
namespace CJDennis\Charset;

trait CharsetTestCommon {
  protected function common_before() {
    CharsetSeam::unset_iconv_library();
    CharsetSeam::unset_iconv_implementation();
  }

  protected function common_after() {
  }

  // tests
  public function testShouldSetGnuLibiconvAsTheIconvLibrary() {
    CharsetSeam::set_iconv_implementation('"libiconv"');
    $this->assertSame('CJDennis\Charset\GnuLibiconv', CharsetSeam::get_iconv_library());
  }

  public function testShouldSetBsdAsTheIconvLibrary() {
    CharsetSeam::set_iconv_implementation('BSD iconv');
    $this->assertSame('CJDennis\Charset\Bsd', CharsetSeam::get_iconv_library());
  }

  public function testShouldSetGlibcAsTheIconvLibrary() {
    CharsetSeam::set_iconv_implementation('glibc');
    $this->assertSame('CJDennis\Charset\Glibc', CharsetSeam::get_iconv_library());
  }

  public function testShouldSetIbmAsTheIconvLibrary() {
    CharsetSeam::set_iconv_implementation('IBM iconv');
    $this->assertSame('CJDennis\Charset\Ibm', CharsetSeam::get_iconv_library());
  }

  public function testShouldThrowAnExceptionForAnUnknownIconvLibrary() {
    $this->compatibilityExpectException(new CharsetException('Unknown iconv library'), function () {
      CharsetSeam::set_iconv_implementation('unknown');
    });
  }

  public function testShouldConvertUnicodeCurlyQuotesToASCIIStraightQuotes() {
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

  public function testShouldConvertUnicodeCurlyQuotesToCP1252CurlyQuotes() {
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

  public function testShouldConvertUnicodeCurrencySignToASCIIQuestionMark() {
    $this->assertSame(
      CharsetTestCharacters::ASCII_QUESTION_MARK,
      Charset::convert(
        CharsetTestCharacters::UTF8_CURRENCY_SIGN)
    );
  }

  public function testShouldConvertUnicodeCurrencySignToCP1252CurrencySign() {
    $this->assertSame(
      CharsetTestCharacters::CP1252_CURRENCY_SIGN,
      Charset::convert(
        CharsetTestCharacters::UTF8_CURRENCY_SIGN,
        'CP1252')
    );
  }

  public function testShouldConvertUnicodeCurrencySignToASCIIAsterisk() {
    $this->assertSame(
      CharsetTestCharacters::ASCII_ASTERISK,
      Charset::convert(
        CharsetTestCharacters::UTF8_CURRENCY_SIGN, 'ASCII', CharsetTestCharacters::ASCII_ASTERISK)
    );
  }
}
