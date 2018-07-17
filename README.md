# **Project Header** #

#### By Paul Krix ####


## **Technology Stack** ##

* Gulp
* Lamp
* SCSS
* Wordpress
    * Advanced Custom Fields PRO
    * Timber Twig Templating


## **Getting Started** ##

Before beginning, it is recommended that you have both [Ruby](http://www.ruby-lang.org/en/downloads/) & [Compass](http://compass-style.org/install/) installed.

### **Environment variables** ###

Before you can do anything else, you will need to setup your environment variables for the installation.
First  copy the site/.env.example file into /site/.env, then using any text editor you choose update these defaults to suit your new environment.

### **Install all dependencies** ###

Using your command line of choice, navigate to the cloned framework folder, then to the site folder, and run the below to get started on a new project.

~~~
$ composer install
~~~

Next, you will need to install all **Node** dependencies, which is an automated process. Navigate to the **assets** folder _(site/app/themes/genesis/assets)_ and run,

~~~
$ npm install
~~~


## **Development & Deployment** ##

This framework uses **Gulp** to both watch and compile the project. Navigate to the **assets** folder _(site/app/themes/genesis/assets)_ and run,

~~~
$ gulp
~~~

Running _gulp_ will compile the contents of the src folder, based on the **gulpfile.js** and copy them to the dist folder once. If you wish to continuously watch for changes in your project, run the following.

~~~
$ gulp watch
~~~


## **Folder Structure** ##

Brief overview of a project's base content

* bin
	* setup.sh
* resources
	* database
* site _(primary site directory)_
	* app
		* languages
		* plugins _(genesis plugin location)_
		* themes _(genesis theme location)_
		* upgrade
		* uploads
	* vendor _(compass install vendor)_
	* wp _(clean wordpress install)_
	* .env
	* .gitignore
	* .htaccess
	* composer.json
	* composer.lock
	* index.php
* README.md

## **Standards** ##


### **Naming Conventions** ###

While no file/class/variable/etc. naming conventions have been standardised, keeping them easy to understand is important. As a suggestion, check out the [BEM Methodology](http://www.getbem.com) for guidance.

Please take note of existing names within existing projects.


### **PHP** ###

Genesis uses PSR-2 for PHP coding standards


## **Further Documentation** ##

* [ACF](https://www.advancedcustomfields.com/) - Advanced Custom Fields _(Wordpress)_.
* [BEM](http://www.getbem.com) - Block Element Modifier methodology.
* [Compass](http://compass-style.org/) - Compass.
* [Gulp](http://gulpjs.com/) - Automation toolkit.
* [NPM](https://www.npmjs.com/) - Package manager.
* [PHP](https://www.php-fig.org/psr/psr-2/) - PSR-2 standards.
* [Ruby](www.ruby-lang.org/) - Ruby.
* [SASS](http://sass-lang.com/) - CSS extension language.
* [Timber](https://www.upstatement.com/timber/) - Timber templating _(Wordpress)_.
* [Wordpress](https://codex.wordpress.org/) - Wordpress.
