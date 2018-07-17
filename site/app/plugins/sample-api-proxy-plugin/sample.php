<?php
/*
Plugin Name: Sample
Description: This is a sample plugin to be used as a template for anything that
needs to access an external API
Author: Paul Krix
Version: 1.0.0
*/

include __DIR__ . '/lib/ApiProxy.php';

$apiProxy = new \Sample\ApiProxy();
