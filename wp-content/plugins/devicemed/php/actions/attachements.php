<?php
function my_attachments( $attachments )
{
  $args = array(

    // title of the meta box (string)
    'label'         => 'Documentation',

    // all post types to utilize (string|array)
    'post_type'     => 'fournisseur',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit

    // include a note within the meta box (string)
    'note'          => 'Ajoutez les documents',

    // text for 'Attach' button in meta box (string)
    'button_text'   => 'AJouter des fichiers',

    // text for modal 'Attach' button (string)
    'modal_text'    => 'Ajouter',

    /**
     * Fields for the instance are stored in an array. Each field consists of
     * an array with three keys: name, type, label.
     *
     * name  - (string) The field name used. No special characters.
     * type  - (string) The registered field type.
     *                  Fields available: text, textarea
     * label - (string) The label displayed for the field.
     */

    'fields'        => array(
      array(
        'name'  => 'title',                          // unique field name
        'type'  => 'text',                           // registered field type
        'label' => __( 'Title', 'attachments' ),     // label to display
      ),
/*      array(
        'name'  => 'caption',                        // unique field name
        'type'  => 'textarea',                       // registered field type
        'label' => __( 'Caption', 'attachments' ),   // label to display
      ),
      array(
        'name'  => 'copyright',                      // unique field name
        'type'  => 'text',                           // registered field type
        'label' => __( 'Copyright', 'attachments' ), // label to display
      ),*/
    ),

  );

  $attachments->register( 'attachments_fournisseur', $args ); // unique instance name
}

add_action( 'attachments_register', 'my_attachments' );