/* 
 * This file is run by mysql at every startup
 */


/* 
 * Required to set the sql_require_primary_key option.
 * Digital ocean MySQL has the option enabled, but laravel 
 * requires it to be disabled sometimes with the raw query 
 * SET SESSION sql_require_primary_key=0
 */
GRANT SESSION_VARIABLES_ADMIN ON *.* TO 'dbuser'@'%';