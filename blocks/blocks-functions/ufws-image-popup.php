<?php 
/**
 * Block Name: Ufws image popup
 *
 * 
 */
?>
<?php $num = rand(); 

?>




<a data-type="popup-image-preview-<?php echo $num; ?>" class="button-text-link with-border-black button-block" type="button"><?php echo get_field('text_link'); ?></a>
<?php 
    if( is_admin() ){
        $style = 'style="display:none;"';
    } else {
        $style = '';
    }   


?>
<div class="popup popup-img-preview" data-popup="popup-image-preview-<?php echo $num; ?>"  data-close-overlay>
    <div class="popup__wrapper" data-close-overlay>
        <div class="popup__content">
            <button class="popup__close button-close" <?php echo $style; ?> type="button">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.5762 6.08643L6.57617 18.0864M6.57617 6.08643L18.5762 18.0864" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                </svg>

            </button>
            <div class="popup__body">
                <?php 
                        
                    $id_img = get_field('image_popup');
                    echo wp_get_attachment_image( $id_img, 'full' ); 
                
                ?>
            </div>
        </div>
    </div>
</div>
<style type="text\css">
    .button-close{
     display: none;
    }
    .popup__body {
        max-width: 400px;
    }
    

</style>
