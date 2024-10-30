<?php
/**
 * Add fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */  
function tbe_attachment_field_credit( $form_fields, $post ) {
    $form_fields['mbgm-youtube-url'] = array(
        'label' => 'Youtube URL',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'mbgm_youtube_url', true ),
        'helps' => 'Add only URL Id like: "16xJsKLEbQw" do not full url like: "https://www.youtube.com/watch?v=16xJsKLEbQw"',
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'tbe_attachment_field_credit', 10, 2 );
 
/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
 
function mbgm_attachment_field_credit_save( $post, $attachment ) {
    if( isset( $attachment['mbgm-youtube-url'] ) )
    update_post_meta( $post['ID'], 'mbgm_youtube_url',  $attachment['mbgm-youtube-url'] );
    return $post;
}
add_filter( 'attachment_fields_to_save', 'mbgm_attachment_field_credit_save', 10, 2 );
?>