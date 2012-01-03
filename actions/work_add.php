<?php

/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$organisation = get_input('organisation');
$jobtitle = get_input('jobtitle');
$description = get_input('description');


// create a new object
$rWork = new ElggObject();
$rWork->startdate = $startdate;
$rWork->enddate = $enddate;
$rWork->organisation = $organisation;
$rWork->jobtitle = $jobtitle;
$rWork->description = $description;
$rWork->title = $jobtitle . " @ " . $organisation;
$rWork->subtype = "rWork";


// public acces for the resume
$rWork->access_id = ACCESS_PUBLIC;

// owner is logged in user
$rWork->owner_guid = get_loggedin_userid();

// save to database
$rWork->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $rWork->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);