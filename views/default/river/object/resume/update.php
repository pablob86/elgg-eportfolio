<?php

$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";

if ($object->getSubtype() == 'rLanguage') {
    $itemType = elgg_echo("resume:languages");
}


if ($object->getSubtype() == 'rReference') {
    $itemType = elgg_echo("resume:references");
}
if ($object->getSubtype() == 'rWork') {
    $itemType = elgg_echo("resume:works");
}

if ($object->getSubtype() == 'rAcademic') {
    $itemType = elgg_echo("resume:academics");
}

if ($object->getSubtype() == 'rTraining') {
    $itemType = elgg_echo("resume:trainings");
}

$string = sprintf(elgg_echo("resume:river:updated"), $url, $itemType) . " ";
$string .= "<a href=\"{$vars['url']}pg/resumes/{$performed_by->username}\">ePortfolio</a>";


echo $string;

