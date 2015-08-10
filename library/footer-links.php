<?php

$footer_links = get_post_meta(get_the_ID(),'_naiau_important_links');

if($footer_links == 'true'){ ?>

	<div class="important-links-wrap">
		<div class="ilink-wrap navy-link">
			<a href="#">اتوماسیون اداری</a>
		</div>
		<div class="ilink-wrap skyblue1-link">
			<a href="#">نمایش فیش حقوق کارکنان و اساتید</a>
		</div>
		<div class="ilink-wrap skyblue2-link">
			<a href="#">دفتر مطالعات آموزشی نیروی انسانی نظرآباد</a>
		</div>
		<div class="ilink-wrap grey-link">
			<a href="#">سامانه ثبت نام و اطلاع رسانی تحصیلی</a>
		</div>
	</div>
<?php } ?>