##### Table of Contents  
* [Intro](#intro)  
* [Requirements](#requirements)  
* [Installation and setup](#installation)  
* [Labeltemplates](#labeltemplates) 

<a name="intro"/>
## Intro

This CakePHP plugin provides a example form and CakePHP component to print labels on a TSPL/TSPL2 compatible labelprinter.

**Currently supports the following label types:**

* QRCODE
* BARCODE
* DMATRIX

<a name="requirements"/>
## Requirements

This plugin is CakePHP Security component compatible.

**Required:**

* [jQuery](http://jquery.com/)

**Optional:**

* [Bootstrap 3](http://getbootstrap.com)

<a name="installation"/>
## Installation and Setup

1. Check out a copy of the Labelprinting CakePHP plugin from the repository using Git :

	`git clone http://github.com/stefanvangastel/CakePHP-Labelprinting.git`

	or download the archive from Github: 

	`https://github.com/stefanvangastel/CakePHP-Labelprinting/archive/master.zip`

	You must place the Labelprinting CakePHP plugin within your CakePHP 2.x app/Plugin directory.
	
	or load it with composer:
	
	`"stefanvangastel/labelprinting": "dev-master"`

2. Load the plugin in app/Config/bootstrap.php:

	`CakePlugin::load('Labelprinting');`

3. Visit http://yoursite.com/labelprinting/example/setup to enter your printer settings

4. Visit http://yoursite.com/labelprinting/example/ to select a template and print some labels

<a name="labeltemplates"/>
## Labeltemplates

* Labeltemplates can be added, updated and removed in the Labeltemplates directory inside the Plugin. You van use TSPL commands as you can see in the examples. 

* Take a look at the example controller to see what you could do using placeholders (start with <<< and end with >>>).
