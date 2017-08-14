<?php
/**
 * The template for displaying search forms in Catch Flames
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */
 
global $catchflames_options_settings;
$options = $catchflames_options_settings;

$catchflames_search_display_text = $options[ 'search_display_text' ];

?>

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<label class="screen-reader-text" for="s">Поиск: </label>
	<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="найти" />
</form>

