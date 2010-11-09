<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
require_once "api/Content/Content.php";
require_once "api/Poll/Poll.php";
/**
 * This class generates inner html of poll
 * @package BlockModules
 * @subpackage 
 */ 

class CCRegions extends Module {
 
  public $module_type = 'group|network'; //'user|group|network'; 
  public $module_placement = 'left|right';
  public $outer_template = 'outer_public_side_module.tpl';
  public $per_option;
  
  function __construct() {
    parent::__construct();
    $this->title = __('Regions');
  }
  function render() {
    $this->inner_HTML = $this->generate_inner_html();
    $content = parent::render();
    return $content;
  }
  
  function generate_inner_html () {
    $inner_template = PA::$blockmodule_path .'/'. get_class($this) . '/side_inner_public.tpl';
    $inner_html_gen = new Template($inner_template);
    $inner_html = $inner_html_gen->fetch();
    return $inner_html;
  }

}
?>
