<?php

class ControllerExtensionModuleMpcatalog extends Controller {
    public function index() {
        $this->load->language('extension/module/mpcatalog');

        $this->load->model('extension/module/mpcatalog');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $data = [];

        $categories = $this->model_extension_module_mpcatalog->getCategoriesForMainPage();

        foreach ($categories as $category) {
            $category['description'] = $this->decodeDescription($category['description']);
            $category['href'] = $this->url->link('product/category', 'path=' . $category['id']);

            $data['categories'][] = $category;
        }

        $products = $this->model_extension_module_mpcatalog->getProductsForMainPage();

        foreach ($products as $product) {
            $productInfo = $this->model_catalog_product->getProduct($product['id']);

            if ($productInfo) {
                $image = $this->model_tool_image->resize($productInfo['image'] ?: 'placeholder.png', 200, 200);

                $price = $this->customer->isLogged() || !$this->config->get('config_customer_price')
                    ? $this->currency->format(
                        $this->tax->calculate(
                            $productInfo['price'],
                            $productInfo['tax_class_id'],
                            $this->config->get('config_tax')),
                        $this->session->data['currency'])
                    : false;

                $special = (float)$productInfo['special']
                    ? $this->currency->format(
                        $this->tax->calculate(
                            $productInfo['special'],
                            $productInfo['tax_class_id'],
                            $this->config->get('config_tax')),
                        $this->session->data['currency'])
                    : false;

                $tax = $this->config->get('config_tax')
                    ? $this->currency->format(
                        (float)$productInfo['special']
                            ? $productInfo['special']
                            : $productInfo['price'],
                        $this->session->data['currency'])
                    : false;

                $rating = $this->config->get('config_review_status')
                    ? $productInfo['rating']
                    : false;

                $data['products'][] = [
                    'id'          => $productInfo['product_id'],
                    'category_id' => $product['category_id'],
                    'name'        => $productInfo['name'],
                    'description' => $this->decodeDescription($productInfo['description']) . '...',
                    'thumb'       => $image,
                    'href'        => $this->url->link('product/product', 'product_id=' . $productInfo['product_id']),
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'rating'      => $rating
                ];
            }
        }

        return $this->load->view('extension/module/mpcatalog', $data);
    }

    private function decodeDescription($description) {
        return utf8_substr(
            strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')),
            0,
            $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length'
            ));
    }
}