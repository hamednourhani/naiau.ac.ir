<?php if ( is_active_sidebar( 'circular-sidebar' )) : ?>
		
		<div class="secondary" id="secondary">
				
				<div id="sidebar-widget" class="sidebar-widget">
					<?php dynamic_sidebar( 'circular-sidebar' ); ?>  
				</div><!--.sticky-widget-->  
				
				
		</div><!--.secondary-->

 <?php endif; ?>