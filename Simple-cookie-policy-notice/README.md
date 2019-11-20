# Simple cookie policy notice plugin for OpenCart

## Requirements

* OpenCart: 3.x
* PHP: >=7.0

## Description

This plugin adds a notice about cookies usage for visitors on OpenCart store. It supports a large number of settings for visual customization, so it should be easy to adjust it to store color scheme.

The notice bar is adaptive and should fit mobile devices nicely. Screenshot of desktop and mobile versions:

![Desktop version](./docs/img/desktop.jpg)

![Mobile version](./docs/img/mobile.jpg)

## Installation and configuration

### Installation form admin panel

1. Download Simple navigation bar plugin [zip](./Simple-cookie-policy-notice.ocmod.zip).

2. Connect to OpenCart admin panel.

3. Upload the plugin:

    ```
    Extensions -> Extensions Installer -> Upload
    ```

4. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Simple cookie policy notice -> Install
    ```

5. Reload plugins cache (blue button in the upper right corner):

    ```
    Extensions -> Modifications
    ```

### Installation by FTP

1. Download Simple navigation bar plugin [zip](./Simple-cookie-policy-notice.ocmod.zip).

2. Connect to server and go to OpenCart root directory.

3. Open upload directory inside downloaded archive.

4. Extract directories to OpenCart root directory.

5. Install the plugin:

    ```
    Extensions -> Extensions -> Modules -> Simple cookie policy notice -> Install
    ```

5. Reload plugins cache (blue button in the upper right corner):

    ```
    Extensions -> Modifications
    ```

### Configuration

1. Go to config page:

    ```
    Extensions -> Extensions -> Modules -> Simple cookie policy notice -> Add new
    ```

2. Change the settings as necessary or leave the default ones.

3. Save changes.

4. Find the layouts of the pages where you want to paste notice bar:

    ```
    Design -> Layouts -> *Layout name* -> Edit
    ```

5. Select the plugin in the drop-down list at the bottom of the **Content Top** section you need.

6. Save changes.

## License

[MIT](https://github.com/overvis/opencart-plugins/blob/master/LICENSE)

## Support

If you have any questions you can ask them [here](https://github.com/overvis/opencart-plugins/issues)
