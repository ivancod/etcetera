<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wp_bootstrap_starter_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
        if ( is_single() ) :
			the_content();
        else :
            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
        endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<table class="my_plugin-table">
		<thead>
			<tr>
				<td>Характеристика</td>
				<td>Значение</td>
			</tr>
		</thead>
		<tbody>
			<? foreach( $_SERVER['acf-field'] as $field ): ?>
				<? if ( !get_field($field['name']) ) continue; ?>

				<? if( !$field['sub_fields'] ){ ?>
					<tr>
						<td><?= $field['label'] ?></td>
						<td><? $field_val = get_field($field['name']);
							if(gettype($field_val) == "string")
								echo $field_val;
							if(gettype($field_val) == "array" AND $field_val['type'] == 'image')  
								echo "<img src='". $field_val['sizes']['thumbnail'] ."' >";
						?></td>
					</tr>
				<? } else { ?>
					<tr><td style="font-weight: 500;" ><?= $field['label'] ?></td><td></td></tr>
					<? foreach( $field['sub_fields'] as $sub_field ): 
						$sub_field['name'] = $field['name'].'_'.$sub_field['name']; ?>
			 			<tr>
							<td><?= $sub_field['label'] ?></td>
							<td><? $sub_field_val = get_field($sub_field['name']);
								if(gettype($sub_field_val) == "string")
									echo $sub_field_val;
								if(gettype($sub_field_val) == "array" AND $sub_field_val['type'] == 'image') 
									echo "<img src='". $sub_field_val['sizes']['thumbnail'] ."' >";
							?></td>
						</tr>
					<? endforeach; ?>
				<? } ?>
			<? endforeach ?>
		</tbody>
	</table>


	<!-- .ACF-content -->
	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer>
</article><!-- #post-## -->
