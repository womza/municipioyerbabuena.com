<?php // RTL language
if ( is_rtl() ) : ?>

	<?php the_posts_pagination(array(
		'mid_size' => 2,
		'prev_text' => '<i class="fa fa-angle-right"></i>',
		'next_text' => '<i class="fa fa-angle-left"></i>',
	)); ?>

<?php // default
else: ?>

	<?php the_posts_pagination(array(
		'mid_size' => 2,
		'prev_text' => '<i class="fa fa-angle-left"></i>',
		'next_text' => '<i class="fa fa-angle-right"></i>',
	)); ?>

<?php endif; ?>