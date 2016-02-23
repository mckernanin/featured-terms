<?php
/**
 * Template for displaying Featured Topics
 *
 * @since      1.0.0
 * @package	   Featured_Topics
 */

$args = array(
	'orderby'    => 'slug',
	'order'      => 'desc',
	'number' => '25',
	'meta_query' => array(
		array(
			'key'     => 'featured',
			'value'   => 'on',
		),
	),
);
$term_count = abs( wp_count_terms( 'post_tag', $args ) );
if ( 0 !== $term_count ) {
	$featured_terms = get_terms( 'post_tag', $args );
	if ( 1 === $term_count ) {
		$title = 'Featured Topic:';
	} else {
		$title = 'Featured Topics:';
	}
	?>
	<div class="featured-topics-display" data-term-count="<?php esc_attr_e( $term_count ); ?>">
		<span class="featured-topics-title"><?php esc_html_e( $title ); ?></span>
		<?php foreach ( $featured_terms as $term ) { ?>
			<a href="<?php esc_attr_e( get_term_link( $term ) ); ?>" ><?php esc_html_e( $term->name ); ?></a>
		<?php } ?>
	</div>
<?php
} else {
	if ( current_user_can( 'administrator' ) ) {
		esc_html_e( 'This is where featured topics would be, if you had any featured terms selected. Don\'t worry, this message is only shown to site admins. ' );
	}
}
