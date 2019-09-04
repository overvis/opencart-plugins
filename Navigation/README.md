# Navigation plugin

### Requirements

* Opencart: 3.x
* PHP: >=7.0

### Description

This plugin allows you to add a navigation bar to your store that will contain a list of product categories and pages selected in the admin panel. It has a large number of settings for visual customization, so it’s easy for you to adjust the navigation bar to the color scheme of your site. Also, the navigation bar is adaptive and will look good on all devices. Below you can see what you get after installing the plugin.

![GitHub Logo](./docs/img/screenshot.jpg)

**Important!** This plugin supports showing only one category level.

### Installation and configuration

* Download Navigation plugin zip
* Connect to Opencart admin panel
* Upload Paysera plugin:

      Extensions -> Extensions Installer -> Upload

* Install plugin:
  
      Extensions -> Extensions -> Modules -> Navigation -> Install
      
* Go to config page:
  
      Extensions -> Extensions -> Modules -> Navigation -> Add new
    
* Change settings according to desire or leave default
* Detect layout of page where you want to paste navigation bar:
  
      Design -> Layouts -> *Layout name* -> Edit
      
* Add the plugin where you need it. It is advisable to add to the very top of the section **Content Top**

### How to add pages to the navigation bar

* Detect a layout link to which will appear in the navigation bar:
  
      Design -> Layouts -> *Layout name* -> Edit
      
* Switch option **Show in navbar** to **Yes**