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
$level = get_input('level');
$enddate = get_input('enddate');
$institution = get_input('institution');
$achieved_title = get_input('achieved_title');



// create a new object
$rAcademic = new ElggObject();
$rAcademic->level = $level;
$rAcademic->enddate = $enddate;
$rAcademic->institution = $institution;
$rAcademic->achieved_title = $achieved_title;
$rAcademic->subtype = "rAcademic";
$rAcademic->title = $achieved_title . " (". $level.")";
$rAcademic->description = $institution;

// public acces for the resume
$rAcademic->access_id = ACCESS_PUBLIC;

// owner is logged in user
$rAcademic->owner_guid = get_loggedin_userid();

// save to database
$rAcademic->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $rAcademic->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);