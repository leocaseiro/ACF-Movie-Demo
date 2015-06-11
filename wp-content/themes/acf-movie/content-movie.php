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
		<h1 class="entry-title"><?php the_title(); ?> <small>(<?php the_field('time'); ?> min)</small></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php $release_date = get_field( 'release_date' ); ?>
		<strong>Released in:</strong> <?php echo date_i18n( 'l, F j, Y', strtotime( $release_date ) ); ?><br />
		<strong>Country:</strong> <?php the_field( 'country' ); ?><br />
		<strong>Classification:</strong> <?php the_field( 'classification' ); ?><br />
		<strong>Director(s):</strong> <?php the_field( 'director' ); ?><br />
		<strong>Writer(s):</strong> <?php echo get_post_meta( get_the_ID(), 'writer', true ); ?><br />
		<hr>

		<?php if ( get_field( 'has_gallery' ) ) : ?>
			<h3>Gallery</h3>
			<?php the_field('gallery'); ?>
			<hr>
		<?php endif; ?>

		<?php if ( get_field( 'has_video' ) ) : ?>
			<h3>Trailer</h3>
			<?php the_field('trailer'); ?>
			<hr>
		<?php endif; ?>

		<h3>Storyline</h3>
		<?php the_content(); ?>
		<hr>

		<h3>Stars</h3>
		<ul>
			<?php $cast = get_field('cast');

	    	foreach( $cast as $post): // variable must be called $post (IMPORTANT)
	        	setup_postdata( $post ); ?>
		        <li>
		            <a href="<?php the_permalink(); ?>"><?php the_title(); ?><br> <?php the_post_thumbnail(); ?></a>
		        </li>
	    	<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
			endforeach;
		?>
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
