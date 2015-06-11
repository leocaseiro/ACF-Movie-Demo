<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		twentyfifteen_post_thumbnail();
	?>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<strong>Country:</strong> <?php the_field( 'country' ); ?><br />
		<hr>

		<?php the_content(); ?>
		<hr>

		<h3>Movies</h3>
		<?php
		/**
		 * Getting from Parent Relationship
		 * @link http://www.advancedcustomfields.com/resources/tutorials/querying-relationship-fields/
		 */
		 $movies = get_posts( array(
			'post_type' => 'movie',
			'meta_query' => array(
				array(
					'key' => 'cast', // name of custom field
					'value' => '"' . get_the_ID() . '"',
					'compare' => 'LIKE'
				)
			)
		));

		?>
		<ul>
			<?php foreach( $movies as $post ) :
				setup_postdata( $post );
			?>
			<li>
	            <a href="<?php the_permalink(); ?>"><?php the_title(); ?><br> <?php the_post_thumbnail(); ?></a>
	        </li>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
			endforeach; ?>
		</ul>

		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>

	</div><!-- .entry-content -->

	<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
