<?php

class ControllerExtensionModuleCookieNotice extends Controller {
    private $error = [];

    /** @noinspection DuplicatedCode */
    public function index() {
        $this->load->language('extension/module/cookie_notice');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/module');

        $queryStringWithUserTokenAndType = http_build_query([
            'user_token' => $this->session->data['user_token'],
            'type' => 'module'
        ]);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (empty($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('cookie_notice', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link(
                'marketplace/extension',
                $queryStringWithUserTokenAndType,
                true
            ));
        }

        $errorsToData = ['warning', 'name', 'block_color', 'text_color', 'button_color', 'button_color_on_hover'];

        foreach ($errorsToData as $value) {
            $data["error_$value"] = !empty($this->error[$value]) ? $this->error[$value] : '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(
                'common/dashboard',
                http_build_query([
                    'user_token' => $this->session->data['user_token']
                ]),
                true
            )
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', $queryStringWithUserTokenAndType, true)
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link(
                'extension/module/cookie_notice',
                $queryStringWithUserTokenAndModuleId = http_build_query([
                    'user_token' => $this->session->data['user_token'],
                    'module_id' => !empty($this->request->get['module_id'])
                        ? $this->request->get['module_id']
                        : null
                ]),
                true
            )
        ];

        $data['action'] = $this->url->link(
            'extension/module/cookie_notice',
            $queryStringWithUserTokenAndModuleId,
            true
        );

        $data['cancel'] = $this->url->link(
            'marketplace/extension',
            $queryStringWithUserTokenAndType,
            true
        );

        if (!empty($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $moduleInfo = $this->model_setting_module->getModule($this->request->get['module_id']);
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
            if (!empty($this->request->post[$value['name']])) {
                $data[$value['name']] = $this->request->post[$value['name']];
            } elseif (!empty($moduleInfo)) {
                $data[$value['name']] = $moduleInfo[$value['name']];
            } else {
                $data[$value['name']] = $value['default'];
            }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/cookie_notice', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/cookie_notice')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (($nameLength = utf8_strlen($this->request->post['name']) < 3) || ($nameLength > 64)) {
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