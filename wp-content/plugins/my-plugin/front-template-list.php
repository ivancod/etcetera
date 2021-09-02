<?php 

$args = array(
	'post_type' => 'objects',
	'posts_per_page' => '5',
	'paged' => 1 
);
$the_query = new WP_Query( $args );

?>

<div id="my_plugin-list">
	<? if( $the_query->have_posts() ): ?>
		<ul>
		<? while( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<li class="box_post" >
				<div class="box_img"><? the_post_thumbnail() ?></div>
				<div class="box_content">	
					<a href="<? the_permalink() ?>"><div class="box_title"><h3><? the_title() ?></h3></div></a>
					<div class="box_text"><?= wp_trim_words( get_the_content(), 30, '...' ); ?></div>
				</div>
			</li>
		<? endwhile; ?>
		</ul>
	<? endif; ?>
</div>

<? if( $the_query->found_posts > 5 ): ?>
	<div id="my_plugin-load_more" data-page="1">Load More</div>
<? endif; ?>