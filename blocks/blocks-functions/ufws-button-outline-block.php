<?php 
/**
 * Block Name: Ufws Outline button
 *
 * 
 */
?>
<div class="content-button-container">
    <div class="inner-content-button-container">
        <?php $target = get_field('target_link') ? 'target="_blank" rel="noreferrer noopener"' : ''; ?>
        <a href="<?php the_field('link_button'); ?>" <?php echo $target; ?> class="button-text-link with-border-black" ><?php the_field('text_button'); ?></a>
    </div>

</div>