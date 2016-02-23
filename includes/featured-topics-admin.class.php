<?php
/**
 * The dashboard functionality of the plugin.
 *
 * @since      1.0.0
 * @package	   Featured_Topics
 */

/**
 * The dashboard functionality of the plugin.
 *
 * @author     Kevin McKernan <kevin@mckernan.in>
 */
class Featured_Topics_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_meta' ) );
		add_action( 'post_tag_add_form_fields', array( $this, 'new_tag_featured_topic_form' ) );
		add_action( 'post_tag_edit_form_fields', array( $this, 'edit_tag_featured_topic_form' ) );
		add_action( 'edit_post_tag', array( $this, 'save_tag_featured_topic' ) );
		add_action( 'create_post_tag', array( $this, 'save_tag_featured_topic' ) );
	}

	public function register_meta() {
		register_meta( 'post_tag', 'featured', '' );
	}

	function new_tag_featured_topic_form() {

		wp_nonce_field( basename( __FILE__ ), 'ft_featured_topic_nonce' ); ?>

		<div class="form-field ft-featured-topic-wrap">
			<label for="ft-featured-topic"><?php esc_html_e( 'Feature this term?', 'featured-topics' ); ?></label>
			<input type="checkbox" name="ft_featured_topic" id="ft-featured-topic" value="" class="ft-featured-topic-field" />
		</div>
	<?php
	}

	function edit_tag_featured_topic_form( $term ) {

	    $featured = get_term_meta( $term->term_id, 'featured', true );
		?>

	    <tr class="form-field ft-featured-topic-wrap">
	        <th scope="row"><label for="ft-featured-topic"><?php esc_html_e( 'Feature this term?', 'featured-topics' ); ?></label></th>
	        <td>
	            <?php wp_nonce_field( basename( __FILE__ ), 'ft_featured_topic_nonce' ); ?>
				<input type="checkbox" name="ft_featured_topic" id="ft-featured-topic" class="ft-featured-topic-field" <?php checked( $featured, 'on' ); ?>/>
	        </td>
	    </tr>
	<?php
	}

	function save_tag_featured_topic( $term_id ) {

	    if ( ! isset( $_POST['ft_featured_topic_nonce'] ) || ! wp_verify_nonce( $_POST['ft_featured_topic_nonce'], basename( __FILE__ ) ) ) {
	        return;
		}

	    $old = get_term_meta( $term->term_id, 'featured', true );
	    $new = isset( $_POST['ft_featured_topic'] ) ? $_POST['ft_featured_topic'] : '';

	    if ( $old && '' === $new ) {
	        delete_term_meta( $term_id, 'featured' );
		}

	    else if ( $old !== $new ) {
	        update_term_meta( $term_id, 'featured', $new );
		}
	}
}

global $Featured_Topics_Admin;
$Featured_Topics_Admin = new Featured_Topics_Admin();
