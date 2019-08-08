<?php

class ControllerExtensionModuleNavigation extends Controller {
    public function index() {
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
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
            ];
        }

        $pages = $this->model_extension_module_navigation->getLayoutsForNavbar();

        foreach ($pages as $page) {
            $page['href'] = $this->url->link($page['route']);

            $data['pages'][] = $page;
        }

        return $this->load->view('extension/module/navigation', $data);
    }
}