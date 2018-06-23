<?php 
/*
 *Sidebar default template file 
 */
?>
<section class="col-sm-4 right-manageheight">
						<section class="right-column full-height">
						<?php 
						/*
						 *Default sidebar 
						 */
						 if(is_active_sidebar('eminds_default_sidebar')){
						 	dynamic_sidebar('eminds_default_sidebar');
						 }
						?>	
						</section>
					</section>