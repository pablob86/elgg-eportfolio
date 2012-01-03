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
if ($page_owner === false || is_null($page_owner)) {
    $page_owner = get_user_by_username($vars['entity']->username);
}

if ($page_owner == get_loggedin_user()) {
    $title = "<h2><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username . "\">" . elgg_echo('resume:my') . "</a></h2>" . "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username . "\">" . elgg_echo("resume:editportfolio") . "</a></p>" . "" . "<p class=\"profile_info_edit_buttons\"><a href=\"#\"onclick=javascript:window.open(\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . get_loggedin_user()->username . "\")>" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
} else {
    $title = "<h2><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . $page_owner->username . "\">" . sprintf(elgg_echo('resume:user'), $page_owner->name) . "</a></h2>" . "<p class=\"profile_info_edit_buttons\"><a href=\"#\"onclick=javascript:window.open(\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
}

if ($vars['full'] == true) {
    $iconsize = "large";
} else {
    $iconsize = "medium";
}

// wrap all profile info
echo "<div id=\"profile_info\">";
?>

<table cellspacing="0">
    <tr>
        <td>

<?php
// wrap the icon and links in a div
echo "<div id=\"profile_info_column_left\">";

echo "<div id=\"profile_icon_wrapper\">";
// get the user's main profile picture
echo elgg_view(
        "profile/icon", array(
    'entity' => $vars['entity'],
    //'align' => "left",
    'size' => $iconsize,
    'override' => true,
        )
);


echo "</div>";
echo "<div class=\"clearfloat\"></div>";
// display relevant links
echo elgg_view("profile/profilelinks", array("entity" => $vars['entity']));

// close profile_info_column_left
echo "</div>";
?>
        </td>
        <td>

            <div id="profile_info_column_middle" >
            <?php
            if ($vars['entity']->canEdit()) {
            ?>
                    <p class="profile_info_edit_buttons">
                        <a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $vars['entity']->username; ?>/edit/"><?php echo elgg_echo("profile:edit"); ?></a>
                    </p>
                <?php
            }
                ?>



<?php
            // Simple XFN
            $rel = "";
            if (page_owner() == $vars['entity']->guid)
                $rel = 'me';
            else if (check_entity_relationship(page_owner(), 'friend', $vars['entity']->guid))
                $rel = 'friend';

            // display the users name
            echo "<h2><a href=\"" . $vars['entity']->getUrl() . "\" rel=\"$rel\">" . $vars['entity']->name . "</a></h2>";

            //insert a view that can be extended
            echo elgg_view("profile/status", array("entity" => $vars['entity']));

            if ($vars['full'] == true) {
?>
                <?php
                $even_odd = null;

                if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0)
                    foreach ($vars['config']->profile as $shortname => $valtype) {
                        if ($shortname != "description") {
                            $value = $vars['entity']->$shortname;
                            if (!empty($value)) {

                                //This function controls the alternating class
                                $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
                ?>
                                <p class="<?php echo $even_odd; ?>">
                                    <b><?php
                                echo elgg_echo("profile:{$shortname}");
                ?>: </b>
                <?php
                                $options = array(
                                    'value' => $vars['entity']->$shortname
                                );

                                if ($valtype == 'tags') {
                                    $options['tag_names'] = $shortname;
                                }

                                echo elgg_view("output/{$valtype}", $options);
                ?>

                                </p>

                        <?php
                            }
                        }
                    }
            }
                        ?>
            </div><!-- /#profile_info_column_middle -->

        </td>
    </tr>
                    <?php if (!get_plugin_setting('user_defined_fields', 'profile')) {
 ?>
        <tr>
            <td colspan="2">
                <div id="profile_info_column_right">
                    <p class="profile_aboutme_title"><b><?php echo elgg_echo("profile:aboutme"); ?></b></p>

                <?php if ($vars['entity']->isBanned()) {
 ?>
                            <div id="profile_banned">
                <?php
                            echo elgg_echo('profile:banned');
                ?>
                            </div><!-- /#profile_info_column_right -->

<?php } else { ?>

    <?php
                            echo elgg_view('output/longtext', array('value' => $vars['entity']->description));
                            //echo autop(filter_tags($vars['entity']->description));
    ?>

<?php } ?>

                                </div><!-- /#profile_info_column_right -->

                            </td>



                        </tr>
<?php } ?>

    </table>

    <div class="resume">
<?php echo $title ?>
        <div class="clearfloat"></div>
        <br/>
<?php
// List Work experience objects
                    if (list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false)) {
?>
            <div class="contentWrapper resume_contentWrapper">
                <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
                <h3> <?php echo elgg_echo('resume:works'); ?> </h3>
                <div class="collapsible_box resume_collapsible_box">
<?php echo list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false); ?>
                            </div>
                        </div> <?php
                    }


// List Academic history objects
                    if (list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false)) {
?>
                        <div class="contentWrapper resume_contentWrapper">
                            <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
                            <h3> <?php echo elgg_echo('resume:academics') ?></h3>
                            <div class="collapsible_box resume_collapsible_box">
<?php echo list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false); ?>
                            </div>
                        </div>
<?php
                    }

// List additional training objects

                    if (list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false)) {
?>
                        <div class="contentWrapper resume_contentWrapper" >
                            <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
                            <h3> <?php echo elgg_echo('resume:trainings'); ?></h3>
                            <div class="collapsible_box resume_collapsible_box">
<?php echo list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false); ?>
                            </div>
                        </div>
<?php
                    }


// List Language objects

                    if (list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true)) {
?>

                        <div class="contentWrapper resume_contentWrapper">
                            <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
                            <h3><?php echo elgg_echo('resume:languages'); ?> </h3>
                            <div class="collapsible_box resume_collapsible_box">
                                <table class="tabla_idiomas">
                                    <tr class="t_h"><td><?php echo elgg_echo('resume:languages:language'); ?></td><td><?php echo elgg_echo('resume:languages:read'); ?></td><td> <?php echo elgg_echo('resume:languages:written'); ?> </td><td> <?php echo elgg_echo('resume:languages:spoken'); ?></td></tr>
    <?php echo list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true); ?>
                                </table>
                            </div>
                        </div>
    <?php
                    }
// List References objects
                    if (list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true)) {
    ?>
                        <div class="contentWrapper resume_contentWrapper" >
                            <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
                            <h3><?php echo elgg_echo('resume:references'); ?> </h3>
                            <div class="collapsible_box resume_collapsible_box">
<?php echo list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true); ?>
                            </div>
                        </div>

<?php
                    }


// Show a message if there aren't any user objects.
                    if (!list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true)
                            && !list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true)
                            && !list_user_objects($page_owner->getGUID(), 'rWork', 0, true, true, true)
                            && !list_user_objects($page_owner->getGUID(), 'rAcademic', 0, true, true, true)
                            && !list_user_objects($page_owner->getGUID(), 'rTraining', 0, true, true, true)
                    ) {
?>
                <div class="contentWrapper">
                    <h3> <?php echo elgg_echo('resume:noentries'); ?></h3>
                </div>
    <?php
                    }
    ?>
</div>




</div><!-- /#profile_info -->

