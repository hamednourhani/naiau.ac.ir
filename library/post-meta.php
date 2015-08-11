<?php
/*
*
*/?>
		<div class="post-meta">
				
						
							
							<span class="meta-date dt-published">
								<i class="fa fa-calendar"></i>
								<?php if(function_exists('jdate')) {
									$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
													esc_url( get_permalink() ),
													esc_attr( get_the_time() ),
													esc_attr( jdate('c',strtotime($post->post_date)) ),
													esc_html( jdate(get_option('date_format'),strtotime($post->post_date)) )
													);
										} else {
									$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
													esc_url( get_permalink() ),
													esc_attr( get_the_time() ),
													esc_attr( get_the_date( 'c' ) ),
													esc_html( get_the_date() )
													);
										}
									echo $date; 
								?>
							</span>
							
						
									
		</div><!--.post-meta-->		