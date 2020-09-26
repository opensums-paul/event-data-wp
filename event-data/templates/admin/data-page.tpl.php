<?php

/**
 * This file is part of the Dutyman plugin for WordPress™.
 *
 * @link      https://github.com/opensums/dutyman-plugin
 * @package   dutyman-plugin
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

$span = '<span style="font-family: Consolas, Monaco, monospace; background: rgba(0,0,0,0.07); padding: 0 4px;">';
$sc1 = '[tt-plus]';

$settings = get_option('event_data_secrets');
$api = new \EventData\TicketTailor\Api([
    'api-key' => $settings['ticket-tailor-api-key'],
]);
$data = $api->getEvents();
$tickets = $api->getEventTickets('ev_410363');
?>

<div class="wrap">

<?php settings_errors() ?>

<h1><?php echo get_admin_page_title() ?></h1>

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
//define data array
var tabledata = [
    {id:1, name:"Oli Bob", progress:12, gender:"male", rating:1, col:"red", dob:"19/02/1984", car:1},
    {id:2, name:"Mary May", progress:1, gender:"female", rating:2, col:"blue", dob:"14/05/1982", car:true},
    {id:3, name:"Christine Lobowski", progress:42, gender:"female", rating:0, col:"green", dob:"22/05/1982", car:"true"},
    {id:4, name:"Brendon Philips", progress:100, gender:"male", rating:1, col:"orange", dob:"01/08/1980"},
    {id:5, name:"Margret Marmajuke", progress:16, gender:"female", rating:5, col:"yellow", dob:"31/01/1999"},
    {id:6, name:"Frank Harbours", progress:38, gender:"male", rating:4, col:"red", dob:"12/05/1966", car:1},
];

//initialize table
var table = new Tabulator("#tickets-table", {
    data:tabledata, //assign data to table
    autoColumns:true, //create columns from data field names
});
</script>

<h2>About the <?php echo $plugin['name'] ?> plugin</h2>

This is <?php echo $plugin['name'] ?> version
<?php echo $plugin['version'] ?>.

</div>
