<?php echo $top_navigation_bar;?>
<div id="container" <?php echo $outer_class;?>>
	<?php echo $header;?>
	<div id="bg_blog_big"></div>     
	<div class="wrapper">    
		<div class="content-container">
			<div class="main-content">
			   <?php
				if ( isset($array_middle_modules) and (count($array_middle_modules) > 0 ) ) {
          		foreach ( $array_middle_modules as $middle_module ) {
            		echo $middle_module;
          		}
        	}
      		?>   
			</div>
			<div class="aside supplementary">
			 <?php if(isset($array_left_modules) and (count($array_left_modules) > 0 ) ) : ?>
				<?php
				foreach ( $array_left_modules as $left_module ){
          		echo $left_module;
        	}
        	?>
				<?php endif; ?>
				<?php if(isset($array_right_modules) and (count($array_right_modules) > 0 ) ) : 
        	foreach ( $array_right_modules as $right_module ){
          		echo $right_module;
        	}
      	 	endif; ?>
			 </div>
		</div>
	</div>
	  
	<?php echo $footer; ?>
</div>
</body>
</html>
