<?php
// $Header: /cvsroot/html2ps/css.pseudo.listcounter.inc.php,v 1.4 2006/09/07 18:38:14 Konstantin Exp $

class CSSPseudoListCounter extends CSSPropertyHandler {
  function __construct() { CSSPropertyHandler::__construct(true, false); }
  function default_value() { return 0; }

  function getPropertyCode() {
    return CSS_HTML2PS_LIST_COUNTER;
  }

  function getPropertyName() {
    return '-html2ps-list-counter';
  }

}

(new CSS())->register_css_property(new CSSPseudoListCounter);

?>