<div id="my_plugin-filters" >
	<div id="use_filter"> Использовать фильтр </div>
	<form action="#" style="display:none;">
		<div class="fields">
			
		<? foreach( $_SERVER['acf-field'] as $field ): ?>

			<? if( !$field['sub_fields'] ){ ?>
					<? my_plugin_create_field( $field ) ?>
			<? } else { ?>
				<p class="my_plugin_group_title"><?= $field['label']?></p>
				<?php
					foreach( $field['sub_fields'] as $sub_field ): 
						$sub_field['name'] = $field['name'].'_'.$sub_field['name'];
					 	my_plugin_create_field( $sub_field ); 
					endforeach; 
				?>
			<? } ?>
		<? endforeach ?>

		</div>
		<hr>
		<div>
			<button class="btn btn-primary" type="submit">Фильтровать</button>
		</div>

	</form>
</div>
