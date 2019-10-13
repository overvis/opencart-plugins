<?php

class ControllerExtensionModuleNavigation extends Controller {
    public function index($setting) {
        $this->load->language('extension/module/navigation');

        $this->load->model('extension/module/navigation');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $data = [];

        $categories = $this->model_catalog_category->getCategories();

        foreach ($categories as $category) {
            $data['categories'][] = [
                'name' => $category['name'] . ' (' . $this->model_catalog_product->getTotalProducts([
                        'filter_category_id'  => $category['category_id'],
                        'filter_sub_category' => true
                ]) . ')',
                'href' => $this->url->link('product/category', http_build_query([
                    'path' => $category['category_id']
                ]))
            ];
        }

        $pages = $this->model_extension_module_navigation->getLayoutsForNavbar();

        foreach ($pages as $page) {
            $page['href'] = $this->url->link($page['route']);

            $data['pages'][] = $page;
        }

        $fromSettingsToData = [
            'menu_color', 'menu_border_color', 'text_color',
            'button_color_on_hover', 'icon_fa_class', 'dropdown_menu_color'
        ];

        foreach ($fromSettingsToData as $value) {
            $data[$value] = $setting[$value];
        }

        return $this->load->view('extension/module/navigation', $data);
    }
}