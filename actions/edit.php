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
$guid = (int) get_input('id');

if (can_edit_entity($guid)) {

    //get the object to replace the metadata
    $rObject = get_entity($guid);


    $object_metadata_array = get_metadata_for_entity($guid);
    foreach ($object_metadata_array as $meta_object) {
        $name = $meta_object->name;
        $rObject->$name = get_input($name);
    }


// set public acces
    $rObject->access_id = ACCESS_PUBLIC;

// set title and description
    if (get_input('description')) {
        $rObject->description = get_input('description');
    }

    if (get_input('title')) {
        $rObject->title = get_input('description');
    }

    if ($rObject->getSubtype() == "rAcademic") {
        $rObject->title = get_input('achieved_title') . " (" . get_input('level') .")";
        $rObject->description = get_input('institution');
    }

    if ($rObject->getSubtype() == "rWork") {
        $rObject->title = get_input('jobtitle') . " @ " . get_input('organisation');
    }



    $rObject->access_id = ACCESS_PUBLIC;


// save to database
    $rObject->save();
    system_message(elgg_echo('resume:OK'));

// add to river
    add_to_river('river/object/resume/update', 'update', get_loggedin_userid(), $rObject->guid);
} else {
    register_error(elgg_echo('resume:notOK'));
}
// forward user to the main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);