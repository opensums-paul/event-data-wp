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
<p>
List some events here.
</p>
<table id="events-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Event</th>
            <th>Start</th>
            <th>Published</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($data['events'] as $event): ?>
        <tr>
            <td><?php echo($event['id']); ?></td>
            <td><?php echo($event['name']); ?></td>
            <td><?php echo($event['start']['date']); ?></td>
            <td><?php echo($event['status'] === 'published' ? 1 : 0); ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>

<script>
//initialize table
var table = new Tabulator("#events-table", {
    columns:[ //set column definitions for imported table data
        {title:"Id", sorter:"text"},
        {title:"Event", sorter:"number"},
        {title:"Start", xsorter:"date"},
        {title:"Published", formatter:'tick'},
    ],
});
</script>

<h2>Instructions</h2>

<p>
Use the shortcode <?php echo($span.$sc1) ?></span> to do something.
</p>

<pre>
<?php /* echo(json_encode($data['events'], JSON_PRETTY_PRINT));*/ ?>
</pre>

<div id="tickets-table">Table goes here</div>
<pre>
<?php echo(json_encode($tickets, JSON_PRETTY_PRINT)); ?>
</pre>
<script>

/* initialize table
var table = new Tabulator("#tickets-table", {
    data:tabledata, //assign data to table
    autoColumns:true, //create columns from data field names
});
*/
</script>

<h2>About the <?php echo $plugin['name'] ?> plugin</h2>

This is <?php echo $plugin['name'] ?> version
<?php echo $plugin['version'] ?>.

</div>
