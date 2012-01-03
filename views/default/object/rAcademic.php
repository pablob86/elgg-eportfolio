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
/* Object's default view. "Edit" and "Delete" links are added
  based on object's ownership */
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
    $page_owner = get_loggedin_user();
    set_page_owner(get_loggedin_userid());
}
?>


<div>

    <p><span class="strong"><?php echo elgg_echo('resume:academic:level2') . ': '; ?></span><?php echo $vars['entity']->level; ?></p>

    <p><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->achieved_title; ?></a> </p>
    <p><?php echo $vars['entity']->institution . " - "; ?><?php echo $vars['entity']->enddate; ?></p>

    <?php if ($page_owner == get_loggedin_user() && (get_context() != "profile" && get_context() != "profileprint")) {
    ?>
        <p><a
                href="<?php echo $vars['url']; ?>mod/resume/academic.php?id=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo('resume:edit'); ?></a>
            <?php
            echo elgg_view("output/confirmlink", array(
                'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
                'text' => elgg_echo('resume:delete'),
                'confirm' => elgg_echo('resume:delete:element'),
            ));

            // Allow the menu to be extended
            echo elgg_view("editmenu", array('entity' => $vars['entity']));
            ?></p>



    <?php } ?>

                <!-- Comments features -->
    <?php
        if (get_context () != "view") {
             if (get_context () != "profileprint") {
            //get the number of comments
            $num_comments = elgg_count_comments($vars['entity']);
             
    ?>
            <a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo sprintf(elgg_echo("comments")) . " (" . $num_comments . ")"; ?></a><br />
    <?php
    }
        } else {

            echo elgg_view_comments($vars['entity']);

        }
    ?>
    <!-- End of Comments features -->
</div><br />

