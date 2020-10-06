<?php
/*

Plugin Name: Social Bar
Plugin URI:https://github.com/ujw0l/social_bar
Description: Social Bar Widget, lets user to follow you or share you post on social media sites
Version: 2.1.3
Author: Ujwol Bastakoti
Author URI:ujw0l.github.io
text_domain :social-bar
License: GPLv2

*/



class social_bar extends WP_Widget{
    public function __construct() {
        parent::__construct(
            'social_bar', // Base ID
            'Social Bar', // Name
            array( 'description' => __( 'Social Bar,lets user to follow you or share you post on social media site', 'social-bar' ), ) // Args
            );
        
        add_action( 'wp_enqueue_scripts', array($this, 'load_dashicons_front_end') );
        
    }
    
    /**
	 * load dashicon
	 */
    public function load_dashicons_front_end() {
        wp_enqueue_style( 'dashicons' );
    }
    
    /**
	 * Inherited function form
	 * @param $instance form Instance
	 */
    public function form( $instance ) {
        
        if ( isset( $instance[ 'title' ] ) ):
            
            $title = $instance[ 'title' ];
		else:
            $title = __( 'Get Social', 'social-bar' );
        endif;
    
        ?>
				<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'facebook_id' ); ?>"><?php _e( 'Facebook Profile/Page URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_id' ); ?>" name="<?php echo $this->get_field_name( 'facebook_id' ); ?>" type="text" value="<?php if(!empty( $instance[ 'facebook_id' ])){ echo esc_attr( $instance[ 'facebook_id' ]);} ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'twitter_id' ); ?>"><?php _e( 'Twitter Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'twitter_id' ); ?>" type="text" value="<?php if(!empty($instance['twitter_id'])){ echo esc_attr( $instance[ 'twitter_id' ] );} ?>" />
				<p>
				<label for="<?php echo $this->get_field_id( 'linkedin_id' ); ?>"><?php _e( 'Linkedin Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_id' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_id' ); ?>" type="text" value="<?php if(!empty($instance['linkedin_id'])){echo esc_attr( $instance[ 'linkedin_id' ] );} ?>" />
				</p>
				<p>
				<label for="<?php echo $this->get_field_id( 'pinterest_id' ); ?>"><?php _e( 'Pinterest Profile URL:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_id' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_id' ); ?>" type="text" value="<?php if(!empty($instance['pinterest_id'])){echo esc_attr( $instance[ 'pinterest_id' ] );} ?>" />
				</p>
				<ul>
				<li>Rate Review and Bug Report: <a href="https://wordpress.org/plugins/social-bar/#reviews" target="_blank"><span class="dashicons dashicons-flag"></span></a></li>
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
			$instance['facebook_id'] = strip_tags( $new_instance['facebook_id'] );
			$instance['twitter_id'] = strip_tags( $new_instance['twitter_id'] );
			
			$instance['google_id'] = strip_tags( $new_instance['google_id'] );
			$instance['linkedin_id'] = strip_tags( $new_instance['linkedin_id'] );
			$instance['pinterest_id'] = strip_tags( $new_instance['pinterest_id'] );
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
			
		 
		    wp_enqueue_style( 'socialbarCss', plugins_url('css/style.css',__FILE__ )); //register css;
			
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
		
			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
			?>
		
	
			
			
			 <section class="ctcSocialbarWidgetMain">
			
				<ol class="ctcSocialbarWidgetChGrid">
				<?php 
					if(!empty( $instance['facebook_id']))
					{
					?>
					
						<li style="border:0px solid rgba(0,0,0,0);">
						<div class="ctcSocialbarWidgetChItem">
							<div class="ctcSocialbarWidgetChInfo ctcSocialbarWidgetChInfoFacebook" title="Facebook">
								<div class="ctcSocialbarWidgetChInfoFront ctcSocialbarWidgetChFacebook"></div>
								<div class="ctcSocialbarWidgetChInfoBack ctcSocialbarWidgetChInfoBackFacebook">
								<div class="ctcSocialbarWidgetTooltipP"  id="ctcSocialbarWidgetFacebookTooltip" >
									<a class="ctcSocialbarWidgetFacebookTooltip dashicons-before dashicons-share" style="color:rgba(255,255,255, 1);text-decoration:none;" href="https://www.facebook.com/sharer/sharer.php?u=<?=the_permalink()?>"  target="_blank" title="Share this page on Facebook"></a>   
									<a  class="ctcSocialbarWidgetFacebookTooltip dashicons-before dashicons-admin-users" style="color:rgba(255,255,255, 1);text-decoration:none;" href="<?=esc_attr( $instance[ 'facebook_id' ])?>"  target="_blank" title="Visit Facebook profile"></a>
									</div>
								 
								</div>
							</div>
						</div>
					</li>
					
					<?php }
					if(!empty($instance[ 'twitter_id' ]))
					{
					?>
					<li style="border:0px solid rgba(0,0,0,0);">
						<div class="ctcSocialbarWidgetChItem">
							<div class="ctcSocialbarWidgetChInfo ctcSocialbarWidgetChInfoTwitter" title="Twitter">
								<div class="ctcSocialbarWidgetChInfoFront ctcSocialbarWidgetChTwitter" ></div>
								<div class="ctcSocialbarWidgetChInfoBack ctcSocialbarWidgetChInfoBackTwitter">
								<div class="ctcSocialbarWidgetTooltipP"  id="ctcSocialbarWidgetTwitterTooltip" >
								<a class="ctcSocialbarWidgetTwitterTooltip dashicons-before dashicons-share" style="color:rgba(255,255,255, 1);text-decoration:none;" href="http://twitter.com/share?url=<?=the_permalink().'&hashtags='.get_bloginfo( 'name' ).','.get_bloginfo('description').'&via='.str_replace('https://twitter.com/', '',esc_attr( $instance[ 'twitter_id' ]))?>"  target="_blank" title="Tweet this page on Twitter"></a>
								
								 <a class="ctcSocialbarWidgetTwitterTooltip dashicons-before dashicons-admin-users" style="color:rgba(255,255,255, 1);text-decoration:none;"  href="<?=esc_attr( $instance[ 'twitter_id' ])?>" target="_blank" title="Visit Twitter page"></a>
								</div>
								</div>
							</div>
						</div>
					</li>
					<?php }
					if(!empty($instance['linkedin_id']))
					{
					?>
					<li style="border:0px solid rgba(0,0,0,0);">
						<div class="ctcSocialbarWidgetChItem">
							<div class="ctcSocialbarWidgetChInfo ctcSocialbarWidgetChInfoLinkedin" title="LinkedIn">
								<div class="ctcSocialbarWidgetChInfoFront ctcSocialbarWidgetChLinkedin"></div>
								<div class=" ctcSocialbarWidgetChInfoBack ctcSocialbarWidgetChInfoBackLinkedin" >
								<div class="ctcSocialbarWidgetTooltipP" id ="ctcSocialbarWidgetLinkedinTooltip" >
									<a class="ctcSocialbarWidgetLinkedinTooltip dashicons-before dashicons-share" style="color:rgba(255,255,255, 1);text-decoration:none;"  href="http://www.linkedin.com/cws/share?url=<?=the_permalink()?>"  target="_blank" title="Share this page on Linkedin"></a> 
									<a class="ctcSocialbarWidgetLinkedinTooltip dashicons-before dashicons-admin-users" style="color:rgba(255,255,255, 1);text-decoration:none;"  href="<?=esc_attr( $instance[ 'linkedin_id' ])?>"  target="_blank" title="Visit Linkedin Page"></a>
									</div>
									</div>
							</div>
						</div>
					</li>
					<?php }
					if(!empty($instance['pinterest_id'])) {?>
					<li style="border:0px solid rgba(0,0,0,0);">
						<div class="ctcSocialbarWidgetChItem">				
							<div class="ctcSocialbarWidgetChInfo ctcSocialbarWidgetChInfoPinterest" title="Pinterest">
								<div class="ctcSocialbarWidgetChInfoFront ctcSocialbarWidgetChPinterest"></div>
								<div class="ctcSocialbarWidgetChInfoBack ctcSocialbarWidgetChInfoBackPinterest" >
									<div class="ctcSocialbarWidgetTooltipP"  id="ctcSocialbarWidgetPinterestTooltip" >
									<a class="ctcSocialbarPinterestTooltip dashicons-before dashicons-admin-post" style="color:rgba(255,255,255, 1);text-decoration:none;"  href="http://pinterest.com/pin/create/link/?url=<?=get_permalink()?>"  target="_blank" title="Pin It"></a>
									<a class="ctcSocialbarWidgetPinterestTooltip dashicons-before dashicons-admin-users" style="color:rgba(255,255,255, 1);text-decoration:none;"  href="<?php echo esc_attr( $instance[ 'pinterest_id' ]);?>"  target="_blank" title="Visit Pinterest profile"></a>
									</div>
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
/** 
*register socail bar widget
*/
function register_social_bar_widget(){
    register_widget( "social_bar" );
}
add_action( 'widgets_init', 'register_social_bar_widget' );



/**
 * Resiter gutenberg block
 */
function socialBarRegisterBlock(){


	// Block Editor Script.
wp_register_script(
   'socialbar-block-editor',
   plugins_url( 'js/socialbar-block.js',__FILE__ ),
   array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n','wp-data' ),
);

 // Block front end styles.
 wp_register_style(
	'socialbar-block-front-end-styles',
	plugins_url( 'css/style.css',__FILE__ ),
	array('dashicons')

 );

 // Block editor styles.
 wp_register_style(
	'socialbar-block-editor-styles',
	plugins_url( 'css/editor-style.css',__FILE__ ),
	array( 'wp-edit-blocks','dashicons' ),
 );

register_block_type(
   'take-pic/take-pic-block',
   array(
	  'style'         => 'socialbar-block-front-end-styles',
	  'editor_style'  => 'socialbar-block-editor-styles',
	  'editor_script' => 'socialbar-block-editor',
   )
);

}

add_action( 'init', 'socialBarRegisterBlock' );

