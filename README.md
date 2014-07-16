##### Table of Contents  
* [Intro](#intro)  
* [Requirements](#requirements)  
* [Installation and setup](#installation)  
* [Usage / Demo](#usage) 
* [Examples](#examples)  

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

* [Bootstrap](http://getbootstrap.com) (Bootstrap 2 and 3 compatible)

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
