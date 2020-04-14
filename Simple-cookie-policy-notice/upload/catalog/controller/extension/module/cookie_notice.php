<?php

class ControllerExtensionModuleCookieNotice extends Controller {
    public function index($setting) {
        $this->load->language('extension/module/cookie_notice');

        $data['cookie_consent'] = !empty($this->request->cookie['cookie_consent'])
            ? $this->request->cookie['cookie_consent']
            : false;

        $fromSettingsToData = ['block_color', 'text_color', 'button_color', 'button_color_on_hover'];

        foreach ($fromSettingsToData as $value) {
            $data[$value] = $setting[$value];
        }

        return $this->load->view('extension/module/cookie_notice', $data);
    }
}