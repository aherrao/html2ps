<?php
// $Header: /cvsroot/html2ps/css.inc.php,v 1.26 2007/02/18 09:55:10 Konstantin Exp $

class CSS {
  var $_handlers;
  var $_mapping;
  var $_defaultState;
  var $_defaultStateFlags;

  function _getDefaultState() {
    if (!isset($this->_defaultState)) {
      $this->_defaultState = array();

      $handlers = $this->getHandlers();
      foreach ($handlers as $property => $handler) {
        $this->_defaultState[$property] = $handler->default_value();
      }
    }

    return $this->_defaultState;
  }

  function _getDefaultStateFlags() {
    if (!isset($this->_defaultStateFlags)) {
      $this->_defaultStateFlags = array();

      $handlers = $this->getHandlers();
      foreach ($handlers as $property => $handler) {
        $this->_defaultStateFlags[$property] = true;
      }
    }

    return $this->_defaultStateFlags;
  }
  
  function getHandlers() {
    return $this->_handlers;
  }

  function getInheritableTextHandlers() {
    if (!isset($this->_handlersInheritableText)) {
      $this->_handlersInheritabletext = array();
      foreach ($this->_handlers as $property => $handler) {
        if ($handler->isInheritableText()) {
          $this->_handlersInheritableText[$property] =& $this->_handlers[$property];
        }
      }
    }

    return $this->_handlersInheritableText;
  }

  function getInheritableHandlers() {
    if (!isset($this->_handlersInheritable)) {
      $this->_handlersInheritable = array();
      foreach ($this->_handlers as $property => $handler) {
        if ($handler->isInheritable()) {
          $this->_handlersInheritable[$property] =& $this->_handlers[$property];
        }
      }
    }

    return $this->_handlersInheritable;
  }

  function &get() {
    global $__g_css_handler_set;

    if (!isset($__g_css_handler_set)) {
      $__g_css_handler_set = new CSS();
    }

    return $__g_css_handler_set;
  }

  function __construct() {
    $this->_handlers = array();
    $this->_mapping  = array();
  }

  function getDefaultValue($property) {
    $css =& (new CSS())->get();
    $handler =& $css->_get_handler($property);
    $value = $handler->default_value();

    if (is_object($value)) {
      return $value->copy();
    } else {
      return $value;
    }
  }

  function &get_handler($property) {
    $css =& (new CSS())->get();
    $handler =& $css->_get_handler($property);
    return $handler;
  }

  function &_get_handler($property) {
    if (isset($this->_handlers[$property])) {
      return $this->_handlers[$property];
    } else {
      $dumb = null;
      return $dumb;
    }
  }

  function _word2code($key) {
    if (!isset($this->_mapping[$key])) { 
      return null; 
    }

    return $this->_mapping[$key];
  }

  function word2code($key) {
    $css =& (new CSS())->get();
    return $css->_word2code($key);
  }

  function register_css_property(&$handler) {
    $property = $handler->getPropertyCode();
    $name     = $handler->getPropertyName();

    $css =& (new CSS())->get();
    $css->_handlers[$property] =& $handler;
    $css->_mapping[$name] = $property;
  }

  /**
   * Refer to CSS 2.1 G.2 Lexical scanner
   * h		[0-9a-f]
   * nonascii	[\200-\377]
   * unicode		\\{h}{1,6}(\r\n|[ \t\r\n\f])?
   * escape		{unicode}|\\[^\r\n\f0-9a-f]
   * nmstart		[_a-z]|{nonascii}|{escape}
   * nmchar		[_a-z0-9-]|{nonascii}|{escape}
   * ident		-?{nmstart}{nmchar}*
   */
  function is_identifier($string) {
    return preg_match('/-?([_a-z]|[\200-\377]|\\[0-9a-f]{1,6}(\r\n|[ \t\r\n\f])?|\\[^\r\n\f0-9a-f])([_a-z0-9-]|[\200-\377]|\\[0-9a-f]{1,6}(\r\n|[ \t\r\n\f])?|\\[^\r\n\f0-9a-f])*/', $string);
  }
}

?>