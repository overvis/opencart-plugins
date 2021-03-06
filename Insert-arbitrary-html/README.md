# Insert arbitrary html plugin for OpenCart

[View on OpenCart marketplace](https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=38006)

## Compatibility

* OpenCart: 3.0.3.2, 3.0.3.3, 3.0.3.4, 3.0.3.5, 3.0.3.7
* PHP: >=7.0

If you succeed to use this plugin on another versions of OpenCart or PHP let me know.

## Description

This plugin allows to insert an arbitrary HTML code on any page.

![ScreenShot](./docs/img/screenshot.jpg)

## Installation and configuration

### Installation form admin panel

1. Download Insert arbitrary html plugin [zip](./Insert-arbitrary-html.ocmod.zip).

2. Connect to OpenCart admin panel.

3. Upload the plugin:

    ```
    Extensions -> Extensions Installer -> Upload
    ```

4. Reload plugins cache (blue button in the upper right corner):

   ```
   Extensions -> Modifications
   ```

5. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Insert arbitrary html -> Install
    ```

### Installation by FTP

1. Download Insert arbitrary html plugin [zip](./Insert-arbitrary-html.ocmod.zip).

2. Connect to server and go to OpenCart root directory.

3. Open upload directory inside downloaded archive.

4. Extract directories to OpenCart root directory.

5. Connect to OpenCart admin panel.

6. Reload plugins cache (blue button in the upper right corner):

    ```
    Extensions -> Modifications
    ```

7. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Insert arbitrary html -> Install
    ```

### Configuration

1. Go to config page:

    ```
    Extensions -> Extensions -> Modules -> Insert arbitrary html -> Add new
    ```

2. Paste your HTML in text area.

3. Save changes.

4. Find the layouts of the pages where you want to paste notice bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

5. Select the plugin in the drop-down list of the section you need.

6. Save changes.

## License

[MIT](https://github.com/overvis/opencart-plugins/blob/master/LICENSE)

## Support

If you have any questions you can ask them [here](https://github.com/overvis/opencart-plugins/issues)
