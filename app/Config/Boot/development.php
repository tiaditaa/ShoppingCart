<?php

/*
 * ---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 * Set the environment status here.
 *
 * If you are working in a development environment, set this to 'development'.
 * If you are working in a testing environment, set this to 'testing'.
 * If you are working in a production environment, set this to 'production'.
 */
defined('CI_ENVIRONMENT') || define('CI_ENVIRONMENT', 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 * Different environments will require different levels of error reporting.
 * By default, development will show errors but testing and live will hide them.
 */
if (CI_ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
    defined('CI_DEBUG') || define('CI_DEBUG', true);
} elseif (CI_ENVIRONMENT === 'testing') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
    defined('CI_DEBUG') || define('CI_DEBUG', true);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    defined('CI_DEBUG') || define('CI_DEBUG', false);
}
