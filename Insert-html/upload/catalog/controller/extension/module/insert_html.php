<?php

class ControllerExtensionModuleInsertHtml extends Controller {
    public function index($setting) {
        $this->load->language('extension/module/insert_html');

        $data['html'] = htmlspecialchars_decode($setting['html']);

        return $this->load->view('extension/module/insert_html', $data);
    }
}