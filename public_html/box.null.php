<?php
// $Header: /cvsroot/html2ps/box.null.php,v 1.18 2006/07/09 09:07:44 Konstantin Exp $

class NullBox extends GenericInlineBox {
  function get_min_width(&$context) { return 0; }
  function get_max_width(&$context, $limit = 10000000) { return 0; }
  function get_height() { return 0; }

  function __construct() {
    GenericInlineBox::__construct();
  }
  
  function &create() { 
    $box= new NullBox;

    $css_state = new CSSState((new CSS())->get());
    $css_state->pushState();
    $box->readCSS($css_state);

    return $box; 
  }

  function show(&$viewport) {
    return true;
  }

  function reflow_static(&$parent, &$context) {
    // Move current "box" to parent current coordinates. It is REQUIRED, 
    // as some other routines uses box coordinates.
    $this->put_left($parent->get_left());
    $this->put_top($parent->get_top());
  }

  function is_null() { return true; }
}
?>