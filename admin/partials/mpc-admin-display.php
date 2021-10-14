<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://seowp.pl
 * @since      1.0.0
 *
 * @package    mpc
 * @subpackage mpc/admin/partials
 */
?>


<div class="wrap">
	<h1>Tasks</h1>

	<div class="info"></div>
	<div class="container container_task"> 
		
		<div class="tasks"> 

			<ul   class="tasksList"> 
				<form method="POST" enctype="multipart/form-data" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
					<li class="single-task-container single-task-container-first"  data-id="<?php the_ID() ?>"  class="<?php echo ($done ? 'done' : '')?>" >
					
						<input type="hidden" name="taskAddNonce" id="taskAddNonce" value="<?php echo wp_create_nonce('mpc_new_post_nonce') ?>"  />
						<div class="single-task-container--first"> 
							<input type="checkbox" name="is_checked" value="checked" id="is_checked"   />
						</div>
						<div class="single-task-container--sec"><input type="text" name="title" id="title" placeholder="Enter new task here..."  /></div> 
					</li>
				</form>
			<?php
			$args = array('post_type'=>array('posts', 'task'));

			query_posts($args);
		 
			
			if ( have_posts() ) : ?>   
					<?php
					/* Start the Loop */
					while ( have_posts() ) {
						the_post();
						
						$d= get_post_meta(get_the_ID());  
						$field='';

						if (isset($d['is_checked']))
							$field =  $d['is_checked'][0]; 
						 

						?><form method="POST">
						<li class="single-task-container"  data-id="<?php the_ID() ?>" data-nonce="<?php echo wp_create_nonce('mpc_delete_post_nonce') ?>" >
							<div class="single-task-container--first"> 			
								<input type="checkbox" name="is_checked" value="checked" id="is_checked" data-id="<?php the_ID() ?>" class="update_is_checked" data-field="<?php echo $field; ?>" <?php echo $field; ?>  data-nonce="<?php echo wp_create_nonce('mpc_custom_meta_box_nonce') ?>" />
							
							</div>
							<div class="del-me single-task-container--sec">
								<input data-id="<?php the_ID() ?>" type="text"  class="taskName update-post" value="<?php htmlspecialchars(the_title())?>" data-nonce="<?php echo wp_create_nonce('my_edit_post_nonce') ?>"  data-field="<?php echo $field; ?>" />
								
							</div>  
						</li>
						</form>
						<?php 
					}
		 
					?>
					
					<?php

				else :

					;

				endif;
				?>
			</ul>
			
			</div>
			
  </div> 
  <div>Delete task by double clicking on the title</div>
</div> 

</div>
