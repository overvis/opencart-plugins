<?php

class ControllerExtensionModuleCookie extends Controller {
    private $error = [];

    public function index() {
        $this->load->language('extension/module/cookie');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('setting/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('cookie', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->model_setting_setting->editSetting('module_cookie', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        $errorsToData = ['warning', 'name', 'block_color', 'text_color', 'button_color', 'button_color_on_hover'];

        foreach ($errorsToData as $value) {
            $data["error_$value"] = isset($this->error[$value]) ? $this->error[$value] : '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/cookie', 'user_token=' . $this->session->data['user_token'], true)
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/cookie', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            ];
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/cookie', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/cookie', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        $forValidation = [
            ['name' => 'name', 'default' => ''],
            ['name' => 'block_color', 'default' => 'rgba(0, 0, 0, .7)'],
            ['name' => 'status', 'default' => ''],
            ['name' => 'text_color', 'default' => 'white'],
            ['name' => 'button_color', 'default' => '#35f067'],
            ['name' => 'button_color_on_hover', 'default' => '#2bc253']
        ];

        foreach ($forValidation as $value) {
            if (isset($this->request->post[$value['name']])) {
                $data[$value['name']] = $this->request->post[$value['name']];
            } elseif (!empty($module_info)) {
                $data[$value['name']] = $module_info[$value['name']];
            } else {
                $data[$value['name']] = $value['default'];
            }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/cookie', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/cookie')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        $namesForValidation = ['block_color', 'text_color', 'button_color', 'button_color_on_hover'];

        foreach ($namesForValidation as $value) {
            if (!$this->request->post[$value]) {
                $this->error[$value] = $this->language->get("error_$value");
            }
        }

        return !$this->error;
    }
}