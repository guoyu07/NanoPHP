<?php

namespace nanophp\Template;

use nanophp\Libraries\Config;

/**
 * Class: php
 *
 * PHP template class
 */
class php extends \nanophp\Template\Template
{

    /**
     * render
     *
     * Render method in templates does the job and displays the content
     * @param string $__view The name of view file to find
     * @param array $data
     */
    public function render($__view, $data = array())
    {
        // Render the requested view
        $content = $this->renderPartial($__view, $data);

        // Output the rendered view via a default layout
        echo $this->renderPartial(Config::instance()->get('/default_layout', 'layouts/default'), array('content' => $content));
    }

    /**
     * renderPartial
     *
     * Make it available to partialy render a view and do not send it to output
     *
     * @param string $__view
     * @param array $__data
     *
     * @return mixed $content Return view's content
     */
    public function renderPartial($__view, $__data = array())
    {
        // Merging data
        $this->_data = array_merge($__data, $this->_data);
        // Start output buffering
        ob_start();

        // Find the requested view
        include($this->_dir.$__view.'.php');

        // Get contents
        $content = ob_get_contents();

        // Clean buffer
        ob_end_clean();

        // Return content
        return $content;
    }
}
