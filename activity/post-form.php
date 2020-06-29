<?php

/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
if ( !defined( 'ABSPATH' ) ) exit;
?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form" role="complementary">

	<?php do_action( 'bp_before_activity_post_form' ); ?>

	<div id="whats-new-avatar">
		<a href="<?php echo bp_loggedin_user_domain(); ?>">
			<?php bp_loggedin_user_avatar( 'width=' . bp_core_avatar_thumb_width() . '&height=' . bp_core_avatar_thumb_height() ); ?>
		</a>
	</div>

	<h5><?php if ( bp_is_group() )
			printf( __( "Quoi de neuf dans %s, %s?", 'vibe' ), bp_get_group_name(), bp_get_user_firstname() );
		else
			printf( __( "Quoi de neuf, %s?", 'vibe' ), bp_get_user_firstname() );
	?></h5>

	<div id="whats-new-content">
		<div id="whats-new-textarea">
			<textarea name="whats-new" class="bp-suggestions" id="whats-new" cols="50" rows="10"><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_attr( $_GET['r'] ); ?> <?php endif; ?></textarea>
		</div>

		<div id="whats-new-options">
			<div id="whats-new-submit">
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php _e( 'Mis à jour de la publication', 'vibe' ); ?>" />
				<?php do_action('bp_activity_post_form_button'); ?>
			</div>

			<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() && !bp_is_single_course()) : ?>

				<div id="whats-new-post-in-box">

					<select id="whats-new-post-in" name="whats-new-post-in">
						<option selected="selected" value="0"><?php _e( 'Mon Profil', 'vibe' ); ?></option>

						<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0' ) ) :
							while ( bp_groups() ) : bp_the_group(); ?>

								<option value="<?php bp_group_id(); ?>"  data-object="groups"><?php echo sprintf(__('Group : %s ','vibe'),bp_get_group_name()); ?></option>

							<?php endwhile;
						endif; 

						$user_id=get_current_user_id();

						if ( bp_course_has_items(array('user_id'=>$user_id,'per_page'=>999))){

							while ( bp_course_has_items(array('user_id'=>$user_id,'per_page'=>999)) ) : bp_course_the_item();
							?>
							<option value="<?php echo bp_course_get_ID(); ?>"  data-object="course"><?php echo sprintf(__('Cours : %s','vibe'),bp_course_get_name()); ?></option>
							<?php
							endwhile;
						}

						wp_reset_postdata();
						?>
					</select>
					<script>
						jQuery(document).ready(function($){
							$('#whats-new-post-in').on('change',function(){
								var object = $('#whats-new-post-in option:selected').attr('data-object');
								$('#whats-new-post-object').val(object);
							});
							
						});
					</script>
				</div>
				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />

			<?php elseif ( bp_is_group_activity() ) : ?>

				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

			<?php endif; ?>

			<?php do_action( 'bp_activity_post_form_options' ); ?>

		</div><!-- #whats-new-options -->
	</div><!-- #whats-new-content -->

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
	<?php do_action( 'bp_after_activity_post_form' ); ?>

</form><!-- #whats-new-form -->