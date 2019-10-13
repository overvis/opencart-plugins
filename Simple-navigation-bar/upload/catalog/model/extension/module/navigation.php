<?php

class ModelExtensionModuleNavigation extends Model {
    public function getLayoutsForNavbar() {
        $sql = 'SELECT l.name AS name, '
            . 'r.route AS route '
            . 'FROM ' . DB_PREFIX . 'layout l '
            . 'LEFT JOIN ' . DB_PREFIX . 'layout_route r '
            . 'ON l.layout_id = r.layout_id '
            . 'WHERE show_in_navbar = 1';

        $result = $this->db->query($sql);

        return $result->rows;
    }
}