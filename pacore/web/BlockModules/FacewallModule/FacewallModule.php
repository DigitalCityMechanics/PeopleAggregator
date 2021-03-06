<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* FacewallModule.php is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author Martin Spernau
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/


class FacewallModule extends Module {
  
  public $module_type = 'group|network';
  public $module_placement = 'left|right';
  
  public $sort_by = FALSE;
  public $outer_template = 'outer_public_side_module.tpl';
  public $sorting_options;
  public $selected_option;

  function __construct() {
    parent::__construct();
  }

  function render() {
    if (empty($this->links)) {
      $this->do_skip = TRUE;
      return;
    }
    $this->inner_HTML = $this->generate_inner_html ($this->links);
    if( $this->mode == SORT_BY ) {
      $content = $this->inner_HTML;
    }
    else {
      $content = parent::render();
    }
    return $content;
  }

  function generate_inner_html($links) {
    
    $extra = unserialize(PA::$network_info->extra);
    $this->rel_term = __('Friend'); // default title
    if(isset($extra['relationship_show_mode']['term'])) {
      $this->rel_term = $extra['relationship_show_mode']['term'];
    }
    
    if (empty($links)) {
      $this->view_all_url = NULL;
    }
    $inner_template = NULL;
    switch ( $this->mode ) {
      case SORT_BY:
        $inner_template = 'side_inner_sortby.tpl';
      break;
      default:
        $inner_template = 'side_inner_public.tpl';
    }

    $inner_template = PA::$blockmodule_path .'/'. ((get_parent_class($this)) ? get_parent_class($this) : get_class($this)) . '/'.$inner_template;
    $obj_inner_template = new Template($inner_template);
    $obj_inner_template->set('links', $links);
    $obj_inner_template->set('block_name', $this->html_block_id);
    if ($this->sort_by) {
      $obj_inner_template->set('sort_by', $this->sort_by);
      $obj_inner_template->set('sorting_options', $this->sorting_options);
      $obj_inner_template->set('selected_option', $this->selected_option);
    }
    $obj_inner_template->set('rel_term', $this->rel_term);
    $obj_inner_template->set('current_theme_path', PA::$theme_url);
    $inner_html = $obj_inner_template->fetch();
    return $inner_html;
  }

}
?>
