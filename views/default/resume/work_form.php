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
// Decide wich action to use based on if its and edit or add use case.
if (isset($vars['entity'])) {

    $action = "resume/edit";
} else {

    $action = "resume/work_add";
}
?>

<div class="contentWrapper">
    <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>"
          method="post">

        <p><?php echo elgg_echo('resume:work:startdate'); ?><br />
<?php echo elgg_view('input/calendar', array('internalname' => 'startdate', 'value' => $vars['entity']->startdate)); ?></p>

        <p><?php echo elgg_echo('resume:work:enddate'); ?><br />
            <?php echo elgg_view('input/calendar', array('internalname' => 'enddate', 'value' => $vars['entity']->enddate)); ?></p>

        <p><?php echo elgg_echo('resume:work:organisation'); ?><br />
            <?php echo elgg_view('input/text', array('internalname' => 'organisation', 'value' => $vars['entity']->organisation)); ?></p>

        <p><?php echo elgg_echo('resume:work:jobtitle'); ?><br />
            <?php echo elgg_view('input/text', array('internalname' => 'jobtitle', 'value' => $vars['entity']->jobtitle)); ?></p>

        <p><?php echo elgg_echo('resume:work:description'); ?><br />
            <?php echo elgg_view('input/longtext', array('internalname' => 'description', 'value' => $vars['entity']->description)); ?></p>

<?php echo elgg_view('input/securitytoken'); ?>

        <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p>
        <?php if (isset($vars['entity'])) {
                echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID()));
            } ?>
    </form>
</div>
