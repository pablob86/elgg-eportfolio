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
function resume_init() {


    global $CONFIG;

    // Add menu item to logged users
    if (isloggedin ()) {
        add_menu(elgg_echo('resume:menu:item'), $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
    }

    // Extend profile menu to include resume item
    extend_view('profile/menu/links', 'resume/menu');
 
    // Extend CSS with plugin's CSS
    elgg_extend_view('css', 'resume/css');

    //Extend search

    register_entity_type('object', 'rAcademic');
    register_entity_type('object', 'rWork');
}

function resume_pagesetup() {

    global $CONFIG;

    //Add submenu items to the page

    if (get_context() == "resumes") {
        $page_owner = page_owner_entity();


        // Add page owner's exclusive items to menu
        if ($page_owner == get_loggedin_user()) {
            add_submenu_item(elgg_echo('resume:add:work'), $CONFIG->wwwroot . "mod/resume/work.php");
            add_submenu_item(elgg_echo('resume:add:academic'), $CONFIG->wwwroot . "mod/resume/academic.php");
            add_submenu_item(elgg_echo('resume:add:training'), $CONFIG->wwwroot . "mod/resume/training.php");
            add_submenu_item(elgg_echo('resume:add:language'), $CONFIG->wwwroot . "mod/resume/lang.php");
            add_submenu_item(elgg_echo('resume:add:reference'), $CONFIG->wwwroot . "mod/resume/reference.php");
          
        } else if (isloggedin ()) {
            // Not "Page owner's" exclusive items
            add_submenu_item(elgg_echo('resume:menu:goto'), $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
        }
    }


    // Add "cancel" option if the user is in a create/edit form
    if (get_context() == "resumes_form") {
        $page_owner = page_owner_entity();
        add_submenu_item(elgg_echo('resume:menu:cancel'), $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
    }
}

function resume_page_handler($page) {
global $CONFIG;
    // determine wich user resume are we showing
    if (isset($page[0]) && !empty($page[0])) {
        $username = $page[0];



        // forward away if invalid user.
        if (!$user = get_user_by_username($username)) {
            register_error('blog:error:unknown_username');
            forward($_SERVER['HTTP_REFERER']);
        }

        // set the page owner to show the right content
        set_page_owner($user->getGUID());
        $page_owner = page_owner_entity();

        if ($page_owner === false || is_null($page_owner)) {
            $page_owner = get_loggedin_user();
            set_page_owner(get_loggedin_user());
        }

        if ($page_owner == get_loggedin_user()) {
            $area2 = elgg_view_title(elgg_echo('resume:my'));
        } else {
            $area1 = elgg_view_title(sprintf(elgg_echo('resume:user'), $page_owner->name));
        }


        // -------- BEGIN MAIN PAGE CONTENT ---------

    
        $area2 .= '<div class="resume">';
        $area2 .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:goto") . "</a></p>";
        $area2 .=  "<p class=\"profile_info_edit_buttons\"><a href=\"#\"onclick=javascript:window.open(\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
        $area2 .= "<div class=\"clearfloat\"></div>";
        $area2 .= "<br />";
        // List Work experience objects
        if (list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false)) {
            $area2 .= '<div class="contentWrapper resume_contentWrapper" width=716>';
            $area2 .= "<p><a class=\"collapsibleboxlink resume_collapsibleboxlink\">" . "+" . "</a></p>";
            $area2 .= '<h3>' . elgg_echo('resume:works') . '</h3>';
            $area2 .= "<div class=\"collapsible_box resume_collapsible_box\">";
            $area2 .= list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false);
            $area2 .= "</div>";
            $area2 .= "</div>";
        }

// List Academic history objects
        if (list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false)) {
            $area2 .= '<div class="contentWrapper resume_contentWrapper" width=716>';
            $area2 .= "<p><a class=\"collapsibleboxlink resume_collapsibleboxlink\">" . "+" . "</a></p>";
            $area2 .= '<h3>' . elgg_echo('resume:academics') . '</h3>';
            $area2 .= "<div class=\"collapsible_box resume_collapsible_box_hidden\">";
            $area2 .= list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false);
            $area2 .= "</div>";
            $area2 .= "</div>";
        }

// List additional training objects
        if (list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false)) {
            $area2 .= '<div class="contentWrapper resume_contentWrapper" width=716>';
            $area2 .= "<p><a class=\"collapsibleboxlink resume_collapsibleboxlink\">" . "+" . "</a></p>";
            $area2 .= '<h3>' . elgg_echo('resume:trainings') . '</h3>';
            $area2 .= "<div class=\"collapsible_box resume_collapsible_box_hidden\">";
            $area2 .= list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false);
            $area2 .= "</div>";
            $area2 .= "</div>";
        }


// List Language objects

        if (list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true)) {

            $area2 .= '<div class="contentWrapper resume_contentWrapper">';
            $area2 .= "<p><a class=\"collapsibleboxlink resume_collapsibleboxlink\">" . "+" . "</a></p>";
            $area2 .= '<h3>' . elgg_echo('resume:languages') . '</h3>';
            $area2 .= "<div class=\"collapsible_box resume_collapsible_box_hidden \">";
            $area2 .= '<table class="tabla_idiomas">';
            $area2 .= '<tr class="t_h"><td>' . elgg_echo('resume:languages:language') . '</td><td>' . elgg_echo('resume:languages:read') . '</td><td>' . elgg_echo('resume:languages:written') . '</td><td>' . elgg_echo('resume:languages:spoken') . '</td></tr>';
            $area2 .= list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true);
            $area2 .= '</table>';
            $area2 .= "</div>";
            $area2 .= '</div>';
        }
// List References objects
        if (list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true)) {
            $area2 .= '<div class="contentWrapper resume_contentWrapper" width=716>';
            $area2 .= "<p><a class=\"collapsibleboxlink resume_collapsibleboxlink\">" . "+" . "</a></p>";
            $area2 .= '<h3>' . elgg_echo('resume:references') . '</h3>';
            $area2 .= "<div class=\"collapsible_box resume_collapsible_box_hidden\">";
            $area2 .= list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true);
            $area2 .= '</div>';
            $area2 .= '</div>';
        }


// Show a message if there aren't any user objects.
        if (!list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true)
                && !list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true)
                && !list_user_objects($page_owner->getGUID(), 'rWork', 0, true, true, true)
                && !list_user_objects($page_owner->getGUID(), 'rAcademic', 0, true, true, true)
                && !list_user_objects($page_owner->getGUID(), 'rTraining', 0, true, true, true)
        ) {

            $area2 .= '<div class="contentWrapper">';
            $area2 .= '<h3>' . elgg_echo('resume:noentries') . '</h3>';
            $area2 .= '</div>';
        }

        $area2 .= '</div>';
        set_context('resumes');

        $area0 = elgg_view("resume/search");

        $body = elgg_view_layout("two_column_left_sidebar", $area0, $area1 . $area2);
        page_draw(sprintf(elgg_echo('resume:user'), $page_owner->name), $body);

        // -------- END MAIN PAGE CONTENT ---------
    } else if (isloggedin ()) {
        // Forward to user's resume if not user is provided
        forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
    } else {
        // Forward to main page if not logged in
        forward($_SERVER['HTTP_REFERER']);
    }

    if (isset($page[1])) {
        switch ($page[1]) {

        }
    }
}

function printed_page_handler($page) {
?>

<?php

echo elgg_view("page_elements/header");
?>
   <div class="resume_body_printer">

   <?php
    set_context("profileprint");
    global $CONFIG;
    /**
     * Elgg user display (details)
     *
     * @package ElggProfile
     *
     * @uses $vars['entity'] The user entity
     */
    // determine wich user resume are we showing
    if (isset($page[0]) && !empty($page[0])) {
        $username = $page[0];



        // forward away if invalid user.
        if (!$user = get_user_by_username($username)) {
            register_error('blog:error:unknown_username');
            forward($_SERVER['HTTP_REFERER']);
        }

        // set the page owner to show the right content
        set_page_owner($user->getGUID());
        $page_owner = page_owner_entity();

        if ($page_owner === false || is_null($page_owner)) {
            $page_owner = get_loggedin_user();
            set_page_owner(get_loggedin_user());
        }


        $iconsize = "medium";


// wrap all profile info
?>

        <div id="profile_info_printed">


    <?php
// wrap the icon and links in a div
        // display the users name
  
        echo "<h1>" . $page_owner->name . "</h1>";
        echo "<br/>";
        echo "<strong>" . elgg_echo("resume:profileurl") . ":</strong><a href=\"" . $page_owner->getUrl() . "\">" . $page_owner->getUrl() . "</a>";
        echo "<div style=\"float:right;\">";
// get the user's main profile picture
        echo elgg_view(
                "profile/icon", array(
            'entity' => $page_owner,
            //'align' => "left",
            'size' => $iconsize,
            'override' => true,
                )
        );


        echo "</div>";
        echo "<br/>";
// display relevant links
// close profile_info_column_left
      
    ?>

        <div class="print-block">

        <?php
        // Simple XFN
        $rel_type = "";
        if (get_loggedin_userid() == $page_owner->guid) {
            $rel_type = 'me';
        } elseif (check_entity_relationship(get_loggedin_userid(), 'friend', $page_owner->guid)) {
            $rel_type = 'friend';
        }

        if ($rel_type) {
            $rel = "rel=\"$rel_type\"";
        }



        //insert a view that can be extended
        echo elgg_view("profile/status", array("entity" => $vars['entity']));
        ?>
        <?php
        $even_odd = null;

        if (is_array($CONFIG->profile) && sizeof($CONFIG->profile) > 0)
            foreach ($CONFIG->profile as $shortname => $valtype) {
                if ($shortname != "description") {
                    $value = $page_owner->$shortname;
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
                            'value' => $page_owner->$shortname
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
        ?>
    </div><!-- /#profile_info_column_middle -->


    <?php if (!get_plugin_setting('user_defined_fields', 'profile')) {
    ?>

            <div class="print-block">
                <p class="profile_aboutme_title"><b><?php echo elgg_echo("profile:aboutme"); ?></b></p>

        <?php if ($page_owner->isBanned()) {
 ?>
                <div>
            <?php
                echo elgg_echo('profile:banned');
            ?>
            </div><!-- /#profile_info_column_right -->

<?php } else { ?>

        <?php
                echo elgg_view('output/longtext', array('value' => $page_owner->description));
                //echo autop(filter_tags($vars['entity']->description));
        ?>

        <?php } ?>

        </div><!-- /#profile_info_column_right -->



    <?php } ?>




    </div><!-- /#profile_info -->

<?php ?>



        <div>
    <?php echo $title ?>

    <?php
// List Work experience objects
        if (list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false)) {
    ?>
            <div class="print-block">

                <h3> <?php echo elgg_echo('resume:works'); ?> </h3>

        <?php echo list_user_objects($page_owner->getGUID(), 'rWork', 0, false, false, false); ?>

        </div> <?php
        }


// List Academic history objects
        if (list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false)) {
        ?>
            <div class="print-block">

                <h3> <?php echo elgg_echo('resume:academics') ?></h3>

        <?php echo list_user_objects($page_owner->getGUID(), 'rAcademic', 0, false, false, false); ?>

        </div>
    <?php
        }

// List additional training objects

        if (list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false)) {
    ?>
            <div class="print-block" >

                <h3> <?php echo elgg_echo('resume:trainings'); ?></h3>

        <?php echo list_user_objects($page_owner->getGUID(), 'rTraining', 0, false, false, false); ?>

        </div>
    <?php
        }


// List Language objects

        if (list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true)) {
    ?>

            <div class="print-block">

                <h3><?php echo elgg_echo('resume:languages'); ?> </h3>

                <table class="tabla_idiomas">
                    <tr class="t_h"><td><?php echo elgg_echo('resume:languages:language'); ?></td><td><?php echo elgg_echo('resume:languages:read'); ?></td><td> <?php echo elgg_echo('resume:languages:written'); ?> </td><td> <?php echo elgg_echo('resume:languages:spoken'); ?></td></tr>
            <?php echo list_user_objects($page_owner->getGUID(), 'rLanguage', 0, true, true, true); ?>
        </table>

    </div>
    <?php
        }
// List References objects
        if (list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true)) {
    ?>
            <div class="print-block" >

                <h3><?php echo elgg_echo('resume:references'); ?> </h3>

        <?php echo list_user_objects($page_owner->getGUID(), 'rReference', 0, true, true, true); ?>

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
            <div class="print-block">
                <h3> <?php echo elgg_echo('resume:noentries'); ?></h3>
            </div>
    <?php
        }
    ?>
    </div>
    </div>

<?php
    }
}

// ******************** REGISTER ACTIONS ******************

register_action("resume/delete", false, $CONFIG->pluginspath . "resume/actions/delete.php");
register_action("resume/edit", false, $CONFIG->pluginspath . "resume/actions/edit.php");



register_action("resume/lang_add", false, $CONFIG->pluginspath . "resume/actions/lang_add.php");

register_action("resume/academic_add", false, $CONFIG->pluginspath . "resume/actions/academic_add.php");

register_action("resume/training_add", false, $CONFIG->pluginspath . "resume/actions/training_add.php");

register_action("resume/work_add", false, $CONFIG->pluginspath . "resume/actions/work_add.php");

register_action("resume/reference_add", false, $CONFIG->pluginspath . "resume/actions/reference_add.php");


// ******************** REGISTER PAGE HANDLER ******************

register_page_handler('resumes', 'resume_page_handler');
register_page_handler('resumesprintversion', 'printed_page_handler');


// ******************** REGISTER EVENT HANDLERS ******************

register_elgg_event_handler('pagesetup', 'system', 'resume_pagesetup');
register_elgg_event_handler('init', 'system', 'resume_init');