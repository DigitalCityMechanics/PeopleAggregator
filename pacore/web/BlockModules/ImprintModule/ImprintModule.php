<?php

class ImprintModule extends Module {

    public $module_type = 'network';
    public $module_placement = 'middle';
    public $outer_template = 'outer_public_module.tpl';

    function __construct() {
        parent::__construct();
        $this->title = __('Imprint');
        $this->block_type = 'ImprintModule';
        $this->html_block_id = 'ImprintModule';
    }

    /**
     * This handles the situation that there has been no inner_HTML generated
     * and then calls {@link Module::render() }.
     *
     * @return string $content  The html code specific to this module, and its outer html
     */
    function render() {
        $this->inner_HTML = $this->generate_inner_html();
        if (!$this->inner_HTML) {
            return "";
        }
        $content = parent::render();
        return $content;
    }

    /**
     * This generates the page specific html to be passed on to the render function.
     * It uses the standard templates to achieve this.
     *
     * @return string $inner_html  The aforementioned page specific html
     */
    function generate_inner_html() {
        $inner_template = PA::$blockmodule_path . '/' . get_class($this) . '/module_content.php';
        $inner_html_gen = new Template($inner_template, $this);
        $inner_html_gen->set('block_name', $this->html_block_id);
        $inner_html = $inner_html_gen->fetch();
        return $inner_html;
    }

}
