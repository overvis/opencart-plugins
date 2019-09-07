<?php

class ModelExtensionModuleCatalogd extends Model {
    public function getProductsForMainPage() {
        $sql = 'SELECT d.product_id AS id, '
            . 'c.category_id AS category_id, '
            . 'p.sort_order AS sort_order '
            . 'FROM ' . DB_PREFIX . 'product_description d '
            . 'LEFT JOIN ' . DB_PREFIX . 'product p '
            . 'ON p.product_id = d.product_id '
            . 'LEFT JOIN ' . DB_PREFIX . 'product_to_category c '
            . 'ON c.product_id = d.product_id '
            . 'WHERE d.product_id IN '
                . '(SELECT product_id FROM ' . DB_PREFIX . 'product WHERE show_on_main_page = 1) '
            . 'ORDER BY p.sort_order';

        $result = $this->db->query($sql);

        return $result->rows;
    }

    public function getCategoriesForMainPage() {
        $sql = 'SELECT d.category_id AS id, '
            . 'd.name AS name, '
            . 'd.description AS description, '
            . 'c.sort_order AS sort_order '
            . 'FROM ' . DB_PREFIX . 'category_description d '
            . 'LEFT JOIN ' . DB_PREFIX . 'category c '
            . 'ON d.category_id = c.category_id '
            . 'WHERE d.category_id IN '
                . '(SELECT category_id FROM ' . DB_PREFIX . 'category) '
            . 'AND d.category_id IN '
                . '(SELECT category_id FROM ' . DB_PREFIX . 'product_to_category WHERE product_id IN '
                    . '(SELECT product_id FROM ' . DB_PREFIX . 'product WHERE show_on_main_page = 1)) '
            . 'ORDER BY c.sort_order';

        $result = $this->db->query($sql);

        return $result->rows;
    }
}