<?php

class ControllerExtensionModuleNavigation extends Controller {
    private $error = [];

    public function index() {
        $this->load->language('extension/module/navigation');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('setting/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('navigation', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->model_setting_setting->editSetting('module_navigation', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        $errorsToData = [
            'warning', 'name', 'menu_color', 'menu_border_color', 'text_color',
            'button_color_on_hover', 'icon_fa_class', 'dropdown_menu_color'
        ];

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
                'href' => $this->url->link('extension/module/navigation', 'user_token=' . $this->session->data['user_token'], true)
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/navigation', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            ];
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/navigation', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/navigation', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        $forValidation = [
            ['name' => 'name', 'default' => ''],
            ['name' => 'status', 'default' => ''],
            ['name' => 'menu_color', 'default' => '#f8f8f8'],
            ['name' => 'menu_border_color', 'default' => '#e7e7e7'],
            ['name' => 'text_color', 'default' => '#333'],
            ['name' => 'button_color_on_hover', 'default' => '#e7e7e7'],
            ['name' => 'icon_fa_class', 'default' => 'fa-th-large'],
            ['name' => 'dropdown_menu_color', 'default' => '#fff']
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

        $this->response->setOutput($this->load->view('extension/module/navigation', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/navigation')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        $namesForValidation = [
            'menu_color', 'menu_border_color', 'text_color',
            'button_color_on_hover', 'icon_fa_class', 'dropdown_menu_color'
        ];

        foreach ($namesForValidation as $value) {
            if (!$this->request->post[$value]) {
                $this->error[$value] = $this->language->get("error_$value");
            }
        }

        return !$this->error;
    }

    public function install() {
        $this->db->query('ALTER TABLE ' . DB_PREFIX . 'layout ADD show_in_navbar int(1) DEFAULT 0');
    }

    public function uninstall() {
        $this->db->query("SET GLOBAL SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
        $this->db->query('ALTER TABLE ' . DB_PREFIX . 'layout DROP show_in_navbar');
    }
}