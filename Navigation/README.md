# Navigation plugin

### Requirements

* Opencart: 3.x
* PHP: >=7.0

### Description

This plugin allows you to add a navigation bar to your store that will contain a list of product categories and pages selected in the admin panel. It has a large number of settings for visual customization, so it’s easy for you to adjust the navigation bar to the color scheme of your site. Also, the navigation bar is adaptive and will look good on all devices. In the screenshots below you can see the appearance of the desktop and mobile version of navigation bar.

![Desktop version](./docs/img/desktop.jpg)

![Mobile version](./docs/img/mobile.jpg)

**Important!** This plugin supports showing only one category level.

### Installation and configuration 

1. Download Navigation plugin zip

2. Connect to Opencart admin panel

3. Upload Paysera plugin:

    ```
    Extensions -> Extensions Installer -> Upload
    ```

4. Install plugin:

    ```
    Extensions -> Extensions -> Modules -> Navigation -> Install
    ```

5. Go to config page:

    ```
    Extensions -> Extensions -> Modules -> Navigation -> Add new
    ```

6. Change the settings as necessary or leave the default ones.

7. Save changes

8. Detect layout of page where you want to paste navigation bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

9. Add the plugin where you need it. It is advisable to add to the top of the section **Content Top**

10. Save changes

### How to add pages to the navigation bar

1. Detect a layout link to which will appear in the navigation bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

2. Switch option **Show in navbar** to **Yes**

3. Save changes

### Support

If you have any questions you can ask them here https://github.com/overvis/relaysales/issues