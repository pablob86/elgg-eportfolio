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
    <p class="strong"><?php echo $vars['entity']->organisation . " "; ?> <?php echo "(" . $vars['entity']->startdate . " - "; ?><?php echo $vars['entity']->enddate . ")"; ?></p>

    <p><span class="strong"><?php echo elgg_echo('resume:work:jobtitle') . ': '; ?></span><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->jobtitle; ?></a> </p>
       <p> <h4><?php echo elgg_echo('resume:work:description'); ?></h4>
  
        <?php echo $vars['entity']->description; ?>



    <?php if ($page_owner == get_loggedin_user() && (get_context() != "profile" && get_context() != "profileprint")) {
    ?>
            <p><a
                    href="<?php echo $vars['url']; ?>mod/resume/work.php?id=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo('resume:edit'); ?></a>
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

