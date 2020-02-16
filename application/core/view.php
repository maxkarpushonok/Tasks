<?php

/**
 * Class View
 * Abstract class of view
 */
class View {
    /**
     * @param $content_view
     * @param $template_view
     * @param null $data
     * @param null $param
     */
    public function generate($content_view, $template_view, $data = null, $param = null) {
        include 'application/views/'.$template_view;
    }
}