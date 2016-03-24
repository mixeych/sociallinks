<?php

class MIXSocialLinks extends WP_Widget {


	function __construct() {
		parent::__construct(
			'social_links', 
			'Social Links',
			array( 'description' => 'add social links',  )
		);

	}

	function widget( $args, $instance ) {

		?>
		
			<ul>
				<?php 
					foreach ($instance as $key => $link){
						if(!empty($link)){
							$class = $key;
							if($key == 'google'){
								$class = 'google-plus';
							}
							echo "<li><a href='".$link."' target='_blank'><i class='fa fa-".$class."'></i></a></li>";
						}
					}
				?>
			</ul>

		<?php
	}

	function form( $instance ) {

		?>
		<div class="social-form">
		<?php 
		foreach ($instance as $key => $value){
			if($value !== null):
			?>
			<p>
				<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $key; ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>">
				<a class="del-social" href="javascript:void(0)">del</a>
			</p>
			<?php
			endif;
		}
		?>
		</div>
		<button class="social-add-button">add</button>
		<script>
		function removeSocial(){
			if(jQuery(this).hasClass("new")){
				jQuery(this).parents("div.new").remove();
			}else{
				jQuery(this).parent().remove();
			}
		}

			jQuery(".del-social").click(removeSocial);
			jQuery(".social-add-button").click(function(e){
				e.preventDefault();
				var preName = '<?php echo $this->get_field_name("new"); ?>';
				var i = 0;
				var rows = jQuery(this).siblings(".social-form").find(".new").length;
				if(rows){
					i = rows/2;
				}
				
				var title = '[new]['+i+'][title]';
				var link = '[new]['+i+'][link]';

				title = preName.replace('[new]', title)
				link = preName.replace('[new]', link)
				var row = "<div class='new'><p>Title<input class='widefat' class='new-link title' name='"+title+"' type='text' value=''></p><p>Link<input class='widefat' class='new-link link' name='"+link+"' type='text' value=''><a class='del-social new' href='javascript:void(0)'>del</a></p></div>";
				jQuery(".social-form").append(row);
				jQuery(".social-form p:last-child").children(".del-social").click(removeSocial);
			});
		</script>
		<?php 
	}

	function update( $new_instance, $old_instance ) {
		foreach($new_instance as $key => $inst){
			if($key != 'new'){
				if(!empty($key)){
					$instance[$key] = ( ! empty( $inst ) ) ? strip_tags( $inst ) : '';
				}
			}else{
				foreach ($inst as $soc){
					if(!empty($soc['title'])){
						$instance[$soc['title']] = $soc['link'];
					}
				}
			}
			
		}
		return $instance;
	}

} 


function MIX_register_widgets() {
	register_widget( 'MIXSocialLinks' );
}
add_action( 'widgets_init', 'MIX_register_widgets' );