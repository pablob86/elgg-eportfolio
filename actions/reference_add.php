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
$name = get_input('name');
$ocupation = get_input('ocupation');
$organisation = get_input('organisation');
$jobtitle = get_input('jobtitle');
$tel = get_input('tel');


// create a new object
$rReference = new ElggObject();
$rReference->name = $name;
$rReference->ocupation = $ocupation;
$rReference->organisation = $organisation;
$rReference->jobtitle = $jobtitle;
$rReference->tel = $tel;
$rReference->subtype = "rReference";


// public acces for the resume
$rReference->access_id = ACCESS_PUBLIC;

// owner is logged in user
$rReference->owner_guid = get_loggedin_userid();

// save to database
$rReference->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $rReference->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);