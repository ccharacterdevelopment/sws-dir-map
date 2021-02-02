<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header-carousel'); ?>
<div class="layout-container full--until-large">
  <div class="flex-container cf">
    <div class="shift-left--fluid column__primary bg--white can-be--dark-light no-pad--btm">
      <div class="pad--primary spacing">
        <div class="text article__body spacing"> <?php 
		the_content(); 
		
		$args = array(
	'depth'       => 0,
	'sort_column' => 'menu_order, post_title',
	'menu_class'  => 'menu',
//	'include'../../themes/nadfm-theme/     => '',
	'exclude'     => '572,149',
	'echo'			=> false
);
		
		$tmp=wp_page_menu($args); 
		
		$replaceArr=array( // manually add things like EVENTS and DEVOTIONALS
		array('<li class="page_item page-item-23"><a href="https://fm.nadadventist.org/contact-us/">Contact Us</a></li>',
		'<li class="page_item page-item-23"><a href="https://fm.nadadventist.org/contact-us/">Contact Us</a></li><li class="page_item page-item-23"><a href="https://fm.nadadventist.org/events/">Event Calendar</a></li>')
		);
		
		foreach ($replaceArr as $row) {
			$tmp=str_replace($row[0],$row[1], $tmp);
		}
		
		echo $tmp;
		
		?>
      
        </div>
      </div>
      <?php include(locate_template('templates/block-layout.php')); ?>
    </div> <!-- /.shift-left--fluid -->
    <?php get_sidebar('sws'); ?>
  </div> <!-- /.flex-container -->
</div> <!-- /.layout-container -->
<?php endwhile; ?>