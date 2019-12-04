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

  /**
   * @group tag-codepoint
   */
  public function testShouldConvertConvertibleUnicodeQuestionMarksToASCII() {
    $pieces = [
      CharsetTestCharacters::UTF8_QUESTION_MARK => '?',
      CharsetTestCharacters::UTF8_INVERTED_QUESTION_MARK => '?',
      CharsetTestCharacters::UTF8_DOUBLE_QUESTION_MARK => '??',
      CharsetTestCharacters::UTF8_QUESTION_EXCLAMATION_MARK => '?!',
      CharsetTestCharacters::UTF8_EXCLAMATION_QUESTION_MARK => '!?',
      CharsetTestCharacters::UTF8_SMALL_QUESTION_MARK => '?',
      CharsetTestCharacters::UTF8_FULLWIDTH_QUESTION_MARK => '?',
      CharsetTestCharacters::UTF8_TAG_QUESTION_MARK => '',
    ];
    $this->assertSame(join(' ', array_values($pieces)), Charset::convert(join(' ', array_keys($pieces)), 'ASCII', '*'));
  }

  public function testShouldConvertUnicodeGreekQuestionMarkToASCIISemicolon() {
    $this->assertSame(';', Charset::convert(CharsetTestCharacters::UTF8_GREEK_QUESTION_MARK, 'ASCII', '*'));
  }

  public function testShouldConvertNonconvertibleUnicodeQuestionMarksToASCIIAsterisk() {
    $pieces = [
      CharsetTestCharacters::UTF8_ARMENIAN_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_ARABIC_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_ETHIOPIC_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_LIMBU_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_QUESTIONED_EQUAL_TO => '*',
      CharsetTestCharacters::UTF8_APL_FUNCTIONAL_SYMBOL_QUAD_QUESTION => '*',
      CharsetTestCharacters::UTF8_BLACK_QUESTION_MARK_ORNAMENT => '*',
      CharsetTestCharacters::UTF8_WHITE_QUESTION_MARK_ORNAMENT => '*',
      CharsetTestCharacters::UTF8_LESS_THAN_WITH_QUESTION_MARK_ABOVE => '*',
      CharsetTestCharacters::UTF8_GREATER_THAN_WITH_QUESTION_MARK_ABOVE => '*',
      CharsetTestCharacters::UTF8_COPTIC_OLD_NUBIAN_DIRECT_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_COPTIC_OLD_NUBIAN_INDIRECT_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_REVERSED_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_CIRCLED_IDEOGRAPH_QUESTION => '*',
      CharsetTestCharacters::UTF8_VAI_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_BAMUM_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_PRESENTATION_FORM_FOR_VERTICAL_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_CHAKMA_QUESTION_MARK => '*',
      CharsetTestCharacters::UTF8_ADLAM_INITIAL_QUESTION_MARK => '*',
    ];
    $this->assertSame( join(' ', array_values($pieces)), Charset::convert(join(' ', array_keys($pieces)), 'ASCII', '*'));
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
        CharsetTestCharacters::UTF8_RIGHT_DOUBLE_QUOTATION_MARK
      )
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
        'CP1252'
      )
    );
  }

  public function testShouldConvertUnicodeCurrencySignToASCIIQuestionMark() {
    $this->assertSame(CharsetTestCharacters::ASCII_QUESTION_MARK, Charset::convert(CharsetTestCharacters::UTF8_CURRENCY_SIGN));
  }

  public function testShouldConvertUnicodeCurrencySignToCP1252CurrencySign() {
    $this->assertSame(CharsetTestCharacters::CP1252_CURRENCY_SIGN, Charset::convert(CharsetTestCharacters::UTF8_CURRENCY_SIGN, 'CP1252'));
  }

  public function testShouldConvertUnicodeCurrencySignToASCIIAsterisk() {
    $this->assertSame(CharsetTestCharacters::ASCII_ASTERISK, Charset::convert(CharsetTestCharacters::UTF8_CURRENCY_SIGN, 'ASCII', CharsetTestCharacters::ASCII_ASTERISK));
  }

  public function testShouldConvertUnicodeFrenchAccentedTextToASCIIEnglishUnaccentedText() {
    $this->assertSame('creme brulee facade', Charset::convert('crème brûlée façade'));
  }
}
