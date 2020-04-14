<?php /** @noinspection SqlNoDataSourceInspection */

class ControllerExtensionModuleCatalogDisplay extends Controller {
    private $error = [];

    public function index() {
        $this->load->language('extension/module/catalog_display');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $queryStringWithUserTokenAndType = http_build_query([
            'user_token' => $this->session->data['user_token'],
            'type' => 'module'
        ]);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_catalog_display', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link(
                'marketplace/extension',
                $queryStringWithUserTokenAndType,
                true
            ));
        }

        $data['error_warning'] = !empty($this->error['warning']) ? $this->error['warning'] : '';

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(
                'common/dashboard',
                $queryStringWithUserToken = http_build_query([
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
            'href' => $this->url->link('extension/module/catalog_display', $queryStringWithUserToken, true)
        ];

        $data['action'] = $this->url->link('extension/module/catalog_display', $queryStringWithUserToken, true);

        $data['cancel'] = $this->url->link('marketplace/extension', $queryStringWithUserTokenAndType, true);

        $data['module_catalog_display_status'] = !empty($this->request->post['module_catalog_display_status'])
            ? $this->request->post['module_catalog_display_status']
            : $this->config->get('module_catalog_display_status');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/catalog_display', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/catalog_display')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('setting/setting');

        $settings['module_catalog_display_status'] = 1;
        $this->model_setting_setting->editSetting('module_catalog_display', $settings);

        $this->db->query('ALTER TABLE ' . DB_PREFIX . 'product ADD show_in_catalog int(1) DEFAULT 0');
    }

    public function uninstall() {
        $this->load->model('setting/setting');

        $this->model_setting_setting->deleteSetting('module_catalog_display');

        $this->db->query("SET GLOBAL SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
        /** @noinspection SqlResolve */
        $this->db->query('ALTER TABLE ' . DB_PREFIX . 'product DROP show_in_catalog');
    }
}