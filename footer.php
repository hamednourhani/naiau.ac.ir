		
			<footer class="site-footer">
				<span class="site-credit">
					<?php echo __('All right reserved','naiau'); ?>
				</span>
				<span class="site-statistics">
					<?php 
						if(function_exists(cystats_countHits)){
							echo __('Site State : ','naiau').cystats_countHits(all, $showmode=false).__(" visit ","naiau").' | '.__("Designed by ","naiau").'<a href="http://karait.com">'.__(" Farakaranet","naiau").'</a>';
						} ?>
				</span>
				<?php wp_footer(); ?>
			</footer>
		</div>
	</body>
</html>