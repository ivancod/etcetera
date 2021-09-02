<?php

class my_plugin_createWidget extends WP_Widget {
 
	/*
	 * создание виджета
	 */
	function __construct() {
		parent::__construct(
			'true_top_widget', 
			'Поиск по объектам', // заголовок виджета
			array( 'description' => 'Позволяет произвести поиск по объектам.' ) // описание
		);
	}
 
	/*
	 * фронтэнд виджета
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)
		$posts_per_page = $instance['posts_per_page'];
 
		echo $args['before_widget'];
		
		echo "<div class='my_plugin-widget'>";
		echo "<p class='title'>Поиск объектов</p>";
		echo "<form class='flex'>
				<input class='form-control' type='text'>  
				<input style='margin-left:10px' class='btn btn-primary' type='submit' value='Search'>
			  </form> <hr>";
 
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
 
		$q = new WP_Query(array(
			'post_type'		=> 'objects',
			'posts_per_page' => '5',
		));
		if( $q->have_posts() ): ?>
			<ul class="list">
			<? while( $q->have_posts() ): $q->the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
			<? endwhile; ?>
			</ul>
		<? endif;
		wp_reset_postdata();
 
		echo "</div>";
		echo $args['after_widget'];
	}
 
	/*
	 * бэкэнд виджета
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		if ( isset( $instance[ 'posts_per_page' ] ) ) {
			$posts_per_page = $instance[ 'posts_per_page' ];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Количество постов:</label> 
			<input id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '5'; ?>" size="3" />
		</p>
		<?php 
	}
 
	/*
	 * сохранение настроек виджета
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : '5'; // по умолчанию выводятся 5 постов
		return $instance;
	}
}
 
/*
 * регистрация виджета
 */
function my_plugin_widget() {
	register_widget( 'my_plugin_createWidget' );
}

add_action( 'widgets_init', 'my_plugin_widget' );

function mp_acf_widget(){
	$the_query  =  new WP_Query( array(
			'post_type'		=> 'objects',
			'posts_per_page' => '5',
			's' => $_POST['data'],
		)
	);

	$posts = [];
	while ( $the_query->have_posts() ) : $the_query->the_post(); 
		$posts[] = [
			'link' 	=> get_permalink(),
			'title' => get_the_title(),
		];	
	endwhile;

	echo json_encode($posts);
	wp_die(); 
}

add_action( 'wp_ajax_nopriv_mp_acf_widget', 'mp_acf_widget' );
add_action( 'wp_ajax_mp_acf_widget', 'mp_acf_widget' );