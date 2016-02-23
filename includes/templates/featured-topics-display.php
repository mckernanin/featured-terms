<?php
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
$featured_terms = get_terms( 'post_tag', $args );
$term_count = abs( wp_count_terms( 'post_tag', $args ) );
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
