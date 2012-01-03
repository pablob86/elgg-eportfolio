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

    $action = "resume/lang_add";
}
?>

<div class="contentWrapper">
    <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>"
          method="post">

        <p><?php echo elgg_echo('resume:languages:language'); ?><br />
<?php echo elgg_view('input/text', array('internalname' => 'language', 'value' => $vars['entity']->language)); ?></p>

        <p><?php echo elgg_echo('resume:languages:read'); ?><br />
<?php echo elgg_view('input/radio', array('internalname' => 'read', 'options' => array(elgg_echo('resume:high') => elgg_echo('resume:high'), elgg_echo('resume:med') => elgg_echo('resume:med'), elgg_echo('resume:low') => elgg_echo('resume:low')), 'value' => $vars['entity']->read)); ?></p>

        <p><?php echo elgg_echo('resume:languages:written'); ?><br />
<?php echo elgg_view('input/radio', array('internalname' => 'written', 'options' => array(elgg_echo('resume:high') => elgg_echo('resume:high'), elgg_echo('resume:med') => elgg_echo('resume:med'), elgg_echo('resume:low') => elgg_echo('resume:low')), 'value' => $vars['entity']->written)); ?></p>

        <p><?php echo elgg_echo('resume:languages:spoken'); ?><br />
<?php echo elgg_view('input/radio', array('internalname' => 'spoken', 'options' => array(elgg_echo('resume:high') => elgg_echo('resume:high'), elgg_echo('resume:med') => elgg_echo('resume:med'), elgg_echo('resume:low') => elgg_echo('resume:low')), 'value' => $vars['entity']->spoken)); ?></p>

<?php echo elgg_view('input/securitytoken'); ?>

        <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:languages:save'))); ?></p>
<?php if (isset($vars['entity'])) {
    echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID()));
} ?>
    </form>
</div>
