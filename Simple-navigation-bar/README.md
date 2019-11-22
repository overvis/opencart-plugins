# Simple navigation bar plugin for OpenCart

[View on OpenCart marketplace](https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=37992)

## Requirements

* OpenCart: 3.x
* PHP: >=7.0

## Description

This plugin adds a navigation bar to your OpenCart store. Navigation contains a drop-down list of product categories and some pages (you can select them in the admin panel). Plugin supports a large number of settings for visual customization, so it’s easy to adjust the navigation bar to the color scheme of your site. 

The navigation bar is adaptive and will look good on all devices. In the screenshots below you can see the appearance of the desktop and mobile version of navigation bar.

**Important!** The drop-down list supports only one level of categories.

![Desktop version](./docs/img/desktop.jpg)

![Mobile version](./docs/img/mobile.jpg)

## Installation and configuration

1. Download Simple navigation bar plugin [zip](./Simple-Navigation-Bar.ocmod.zip).

2. Connect to OpenCart admin panel.

3. Upload the plugin:

    ```
    Extensions -> Extensions Installer -> Upload
    ```

4. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Simple navigation bar -> Install
    ```

5. Reload plugins cache (Blue button in the upper right corner):

    ```
    Extensions -> Modifications
    ```

6. Go to config page:

    ```
    Extensions -> Extensions -> Modules -> Simple navigation bar -> Add new
    ```

7. Change the settings as necessary or leave the default ones.

8. Save changes.

9. Find the layout of the page where you want to paste navigation bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

10. Select the plugin in the drop-down list at the top of the section you need.

11. Save changes.

## How to select pages to display in the navigation

1. Find a layout, link to which you want to display in the navigation bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

2. Switch the option **Show in navbar** to **Yes**.

3. Save changes.

## License

[MIT](https://github.com/overvis/opencart-plugins/blob/master/LICENSE)

## Support

If you have any questions you can ask them [here](https://github.com/overvis/opencart-plugins/issues)
