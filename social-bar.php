<?php
/*

Plugin Name: Social Bar
Plugin URI: 
Description: Social Bar Widget
Version: 1.2.0
Author: Ujwol Bastakoti
Author URI:
License: GPLv2

*/

wp_register_style( 'socialbarCss', plugins_url('css/style.css',__FILE__ )); //register css
wp_register_style( 'tooltipCss', plugins_url('css/tooltipster.css',__FILE__ )); //register tooltip css
wp_register_script( 'tooltipJquery', plugins_url('js/jquery.tooltipster.min.js',__FILE__ )); //register tooltip css

class social_bar extends WP_Widget{
		public function __construct() {
			parent::__construct(
					'social_bar', // Base ID
					'Social Bar', // Name
					array( 'description' => __( 'Social Bar', 'text_domain' ), ) // Args
			);
		}
		
		
		public function default_animation($animation,$instance){
			if(isset($instance['animation']))
			{
			   if($animation == $instance['animation'])
			   {
			   	 echo 'selected="selected"';
			   }
			}
		}
		
		public function form( $instance ) {
			
			add_thickbox();//call built in function for thickbox
			
			if ( isset( $instance[ 'title' ] ) ) {
			
					$title = $instance[ 'title' ];
				}
			else {
					$title = __( 'Get Social', 'text_domain' );
				}
				
				
				
				?>
				<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'facebook_id' ); ?>"><?php _e( 'Facebook Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_id' ); ?>" name="<?php echo $this->get_field_name( 'facebook_id' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'facebook_id' ]); ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'twitter_id' ); ?>"><?php _e( 'Twitter Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'twitter_id' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'twitter_id' ] ); ?>" />
				<p>
				<label for="<?php echo $this->get_field_id( 'google_id' ); ?>"><?php _e( 'Google+ Profile URL :' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'google_id' ); ?>" name="<?php echo $this->get_field_name( 'google_id' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'google_id'] ); ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'linkedin_id' ); ?>"><?php _e( 'Linkedin Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_id' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_id' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'linkedin_id' ] ); ?>" />
				</p>
				<ul>
				<li>Rate Review and Bug Report: <a href="http://wordpress.org/support/view/plugin-reviews/social-bar?TB_iframe=true&height=480&amp;width=950" class="thickbox">Support</a></li>
				<li>URL must start with "http//:" or "https//:"</li>
				<li>If only profile ID provided, it won't work</li>
				<li>If field/s left empty, Icon will not display</li>
				</ul>
				
				
				
				
	<?php 
		}

		
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['animation'] = strip_tags( $new_instance['animation'] );
			$instance['facebook_id'] = strip_tags( $new_instance['facebook_id'] );
			$instance['twitter_id'] = strip_tags( $new_instance['twitter_id'] );
			$instance['twitter_hashtags'] = strip_tags( $new_instance['twitter_hashtags'] );
			$instance['twitter_text'] = strip_tags( $new_instance['twitter_text'] );
			$instance['google_id'] = strip_tags( $new_instance['google_id'] );
			$instance['linkedin_id'] = strip_tags( $new_instance['linkedin_id'] );
			return $instance;
		}
		
		
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			wp_enqueue_style('socialbarCss');
			wp_enqueue_style('tooltipCss');
			wp_enqueue_script('tooltipJquery');
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
		
			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
			?>
		
			<!-- Script tp handle tooltip contents and animations --> 
			<script type="text/javascript">
			jQuery(document).ready(function(){
				var tooltipTheme;
				jQuery('.tooltip-p').mouseover(function(){
                     tooltipTheme = jQuery(this).attr('id')+"-theme";
                	 //alert(String(tooltipTheme));
                    });
	            	
	            	
	            	jQuery('.tooltip-p').tooltipster({
	            		functionReady:function(){jQuery('div.tooltipster-base').removeClass('tooltipster-default').addClass(tooltipTheme);},
					 	//theme: tooltipTheme,
					 	animation:'<?php echo($instance['animation']);?>',
					 	interactive: true,
					 	position:'bottom',
					 	arrow:false,
					 	offsetY:-23,
					 	offsetX:24
				   });
				

				})
			</script>
			
			
			<section class="main">
			
				<ol class="ch-grid">
				<?php if(!empty($instance['google_id'])) {?>
					<li>
						<div class="ch-item">				
							<div class="ch-info ch-info-gplus">
								<div class="ch-info-front ch-gplus"></div>
								<div class="ch-info-back ch-info-back-gplus" >
									<p class="tooltip-p"  id="gplus-tooltip" ><a class="gplus-tooltip" href="<?php echo esc_attr( $instance[ 'google_id' ]);?>"  target="_blank">Follow</a></p>
								</div>	
							</div>
						</div>
					</li>
					<?php }
					if(!empty( $instance['facebook_id']))
					{
					?>
					<li>
						<div class="ch-item">
							<div class="ch-info ch-info-facebook">
								<div class="ch-info-front ch-facebook"></div>
								<div class=" ch-info-back ch-info-back-facebook" >
									<p class="tooltip-p"  id="facebook-tooltip" ><a style='font-size: 8px; margin-top:-20px; ' class="facebook-tooltip" href="<?php echo esc_attr( $instance[ 'facebook_id' ]); ?>"  target="_blank">Follow</a></p>
								</div>
							</div>
						</div>
					</li>
					<?php }
					if(!empty($instance[ 'twitter_id' ]))
					{
					?>
					<li>
						<div class="ch-item">
							<div class="ch-info ch-info-twitter">
								<div class="ch-info-back ch-info-front ch-twitter"></div>
								<div class="ch-info-back ch-info-back-twitter ">
								<p class="tooltip-p"  id="twitter-tooltip" ><a class="twitter-tooltip" href="<?php echo esc_attr( $instance[ 'twitter_id' ]); ?>" target="_blank">Follow</a></p>
				
								
								</div>
							</div>
						</div>
					</li>
					<?php }
					if(!empty($instance['linkedin_id']))
					{
					?>
					<li>
						<div class="ch-item">
							<div class="ch-info ch-info-linkedin">
								<div class="ch-info-front ch-linkedin"></div>
								<div class=" ch-info-back ch-info-back-linkedin" >
									<p class="tooltip-p" id ="linkedin-tooltip" ><a class="linkedin-tooltip" style="marginptop:-10em !important;" href="<?php echo esc_attr( $instance[ 'linkedin_id' ]); ?>"  target="_blank">Follow</a></p>
									</div>
							</div>
						</div>
					</li>
					<?php }?>
				</ol>
				
			</section>
		<?php 		
			
			echo $after_widget;
		}
		

}
add_action( 'widgets_init', create_function( '', 'register_widget( "social_bar" );' ) );
