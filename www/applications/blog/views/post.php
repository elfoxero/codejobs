<?php 			
	$URL = path("blog/". $post["Year"] ."/". $post["Month"] ."/". $post["Day"] ."/". $post["Slug"]);		
	$in  = ($post["Tags"] !== "") ? __("in") : NULL;
?>
		<div class="post">
			<div class="post-title">
				<a href="<?php echo $URL; ?>" title="<?php echo stripslashes($post["Title"]); ?>">
					<?php echo stripslashes($post["Title"]); ?>
				</a>
			</div>
			
		
			<div class="post-left">
				<?php echo __("Published") ." ". howLong($post["Start_Date"]) ." $in ". exploding($post["Tags"], "blog/tag/") ." " . __("by") . ' <a href="'. path("blog/author/". $post["Author"]) .'">'. $post["Author"] .'</a>'; ?>
			</div>
			
			<div class="post-right">
				<?php
					if($post["Enable_Comments"]) {
                    ?>
                   		<div class="fb-comments-count" data-href="<?php echo $URL; ?>"></div> <span data-singular="<?php echo __("comment"); ?>"><?php echo __("comments"); ?></span>
                    <?php
					}
				?>
			</div>
			
			<div class="clear"></div>
				
			<div class="post-content">
				<?php
					echo social($URL, $post["Title"] ." ". $URL, FALSE); 
					echo showContent($post["Content"], $URL); 
				?>

				<br /><br />

				<?php 
					echo social($URL, $post["Title"] ." ". $URL, TRUE, FALSE, FALSE, FALSE, TRUE);
					echo display('<p>
									<script type="text/javascript">
										google_ad_client = "ca-pub-4006994369722584";
										/* CodeJobs.biz */
										google_ad_slot = "1672839256";
										google_ad_width = 728;
										google_ad_height = 90;
										</script>
										<script type="text/javascript"
										src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
									</script>
								</p>', 4);
				?>
			</div>
		</div>
		<br /></br />
		<?php
			if($post["Enable_Comments"]) {
				echo fbComments($URL);
			}
		?>
