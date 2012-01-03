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
$language = get_input('language');
$written = get_input('written');
$read = get_input('read');
$spoken = get_input('spoken');


// create a new object
$rLang = new ElggObject();
$rLang->language = $language;
$rLang->written = $written;
$rLang->read = $read;
$rLang->spoken = $spoken;
$rLang->subtype = "rLanguage";


// public acces for the resume
$rLang->access_id = ACCESS_PUBLIC;

// owner is logged in user
$rLang->owner_guid = get_loggedin_userid();

// save to database
$rLang->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $rLang->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);