# OpenCart Catalog display plugin

### Requirements

* Opencart: 3.x
* PHP: >=7.0

### Description

This plugin provides you an ability to display a catalog of selected products on any page. Blocks with categories in which there is at least one product selected for display will be shown on the selected page. The order of displaying categories can be changed in the admin panel. These blocks will include:

* The name of the category, which in combination will be a link to other products from this category

* Category description

* Blocks of products whose output order can also be configured in the admin panel

**Important!** If a product has several categories, it can be displayed several times.

### Installation and configuration

1. Download Catalog display plugin zip.

2. Connect to OpenCart admin panel.

3. Upload the plugin:

    ```
    Extensions -> Extensions Installer -> Upload
    ```

4. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Catalog display -> Install
    ```

8. Find the layout of the page where you want to paste catalog:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

9. Select the plugin in the drop-down list of the section you need.

10. Save changes.

### How to add products to catalog

1. Find the product you want to show in the catalog:

    ```
    Catalog -> Products -> *Product name* -> Edit
    ```
    
2. Go to **Data** section.

3. Switch option **Show in catalog** to **Yes**.

4. Save changes.

### Support

If you have any questions you can ask them [here](https://github.com/overvis/opencart-plugins/issues)