<?php

class ModelExtensionModuleMpcatalog extends Model {
    public function getProductsForMainPage() {
        $sql = 'SELECT d.product_id AS id, '
            . 'c.category_id AS category_id '
            . 'FROM ' . DB_PREFIX . 'product_description d '
            . 'LEFT JOIN ' . DB_PREFIX . 'product_to_category c '
            . 'ON c.product_id = d.product_id '
            . 'WHERE d.product_id IN (SELECT product_id FROM ' . DB_PREFIX . 'product WHERE show_on_main_page = 1)';

        $result = $this->db->query($sql);

        return $result->rows;
    }

    public function getCategoriesForMainPage() {
        $sql = 'SELECT category_id AS id, name '
            . 'FROM ' . DB_PREFIX . 'category_description '
            . 'WHERE category_id IN (SELECT category_id FROM ' . DB_PREFIX . 'category) '
            . 'AND category_id IN ( '
                . 'SELECT category_id FROM ' . DB_PREFIX . 'product_to_category WHERE product_id IN ( '
                    . 'SELECT product_id FROM ' . DB_PREFIX . 'product WHERE show_on_main_page = 1))';

        $result = $this->db->query($sql);

        return $result->rows;
    }
}