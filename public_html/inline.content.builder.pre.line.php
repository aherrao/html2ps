<?php

require_once(HTML2PS_DIR.'inline.content.builder.php');

class InlineContentBuilderPreLine extends InlineContentBuilder {
  function __construct() {
    InlineContentBuilder::__construct();
  }

  /**
   * CSS 2.1 p.16.6
   * white-space: normal
   * This value directs user agents to collapse sequences of whitespace, and break lines as necessary to fill line boxes.
   */
  function build(&$box, $text, &$pipeline) {
    $text = $this->remove_leading_linefeeds($text);
    $text = $this->remove_trailing_linefeeds($text);

    $lines = $this->break_into_lines($text);

    foreach ($lines as $line) {
      $words = $this->break_into_words($this->collapse_whitespace($line));
      foreach ($words as $word) {
        $box->process_word($word, $pipeline);

        $whitespace =& (new WhitespaceBox())->create('', '', $pipeline);
        $box->add_child($whitespace);
      }

      $this->add_line_break($box, $pipeline);
    }
  }
}

?>