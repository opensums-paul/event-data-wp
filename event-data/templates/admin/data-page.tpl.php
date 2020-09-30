<?php
/**
 * This file is part of the Event Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/event-data-wp
 * @package   event-data-wp
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

// Prevent direct access.
defined('ABSPATH') || exit;

$span = '<span style="font-family: Consolas, Monaco, monospace; background: rgba(0,0,0,0.07); padding: 0 4px;">';
$sc1 = '[tt-plus]';

?>

<div class="wrap">
<?php settings_errors() ?>
<h1><?php echo get_admin_page_title() ?></h1>

<?php /*
<h2>Getting started</h2>

<p>
Use the shortcode <?php echo($span.$sc1) ?></span> to do something.
</p>

<form action="options.php" method="post">
<?php
// output security fields for the registered setting "wporg"
settings_fields($pageSlug);
// output setting sections and their fields
do_settings_sections($pageSlug);
// output save settings button - moved up into sections.
// submit_button('Save Settings');
?>
<?php submit_button('Save settings'); ?>
</form>
*/
?>
<h3>Ticket Tailor Events</h3>

<p>
<button id="event-data-get-ticket-tailor-events">Load events</button>
</p>

<div id="event-data-ticket-tailor-events"></div>

<h3>Tickets</h3>
<div id="event-data-ticket-tailor-tickets"></div>

<h2>Instructions</h2>

<ol>
    <li>
Click the "Load events" button to load events from Ticket Tailor.
    </li>
    <li>
Once the events are loaded, click on an event to load the tickets for that event.
    </li>
</ol>

<p><small>This is <?php echo $plugin['name'] ?> version
<?php echo $plugin['version'] ?>.
</small></p>

</div>
