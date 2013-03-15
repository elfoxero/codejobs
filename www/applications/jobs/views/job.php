<?php 
	if (!defined("ACCESS")) {
		die("Error: You don't have permission to access here..."); 
	}
	$URL = path("jobs/". $job["ID_Job"] ."/". $job["Slug"], false, $job["Language"]);
	?>

<div class="job">
	<h2>
		<?php echo getLanguage($job["Language"], true); ?> <a href="<?php echo path("jobs/visit/". $job["ID_Job"], false, $job["Language"]); ?>" target="_blank" title="<?php echo quotes($job["Title"]); ?>"><?php echo quotes($job["Title"]); ?></a>
	</h2>

	<span class="small italic grey">
		<?php 
			echo __("Published") ." ". howLong($job["Start_Date"]) ." ". __("by") .
			' <a title="'. $job["Author"] .'" href="'. path("jobs/author/". $job["Author"]) .'">'. $job["Author"] .'</a> ';
		?>
		<br />
	</span>

	<?php echo display(social($URL, $job["Title"], false), 4); ?>


	<p class="justify">
		<h5><?php echo __("Company name and location")?></h5>
			<p>
				<?php
				echo $job["Company"] .' - '.$job['City'].', '.$job['Country'].'<br/>'; 
				?>
			<p>
		<h5><?php echo __("Job Description")?></h5>
		<p>
			<?php 
				echo stripslashes($job["Description"]); 
			?>
		</p>

		<h5><?php echo __("Additional Information")?></h5>
		<p>
			<ul>
				<li><?php echo __("Salary"). ": $". $job["Salary"] ." ". $job["Salary_Currency"] ?></li>
				<li><?php echo __("Allocation Time"). ": ". __($job["Allocation_Time"]) ?></li>
			</ul>
		</p>

		<p>
			<?php if (!defined("ACCESS")) {
				echo '<span class="small italic grey">';
			    echo __("You must be registered to display this content").'</br/>';
				echo "<a title=" .__("Sign Up"). " href=" .path("users/register"). ">". __("Sign Up"). 
					"</a> ". __("or"). " <a title=" .__("Login"). " href=" .path("users/login"). ">" .__("Login"). "</a></span>";
			} elseif (defined("ACCESS") and $isvacancy == true) {
				echo '<span class="bold">'. __("You have already apply for this vacancy") .'</span>';
			} elseif (defined("ACCESS") and $isvacancy == false) { ?>
			<ul>
				<li><?php echo __("Email"). ": ". $job["Email"] ?></li>
			</ul>
			<input id="jauthor" type="hidden" value="<?php echo $job["Author"]; ?>" />
			<input id="jname" type="hidden" value="<?php echo $job["Title"]; ?>" />

			<?php echo formInput(array(
				"type" => "file", 
				"id" => "cv",
				"name" => "cv",
				"field" => __("Upload your CV here"),
				"p" => true
			));
			?>
			<div id= "message-alert"></div>
			<input id="needcontent" type="hidden" value="<?php echo __("You need to write the content..."); ?>" />
			<input id="success" type="hidden" value="<?php echo __("An email has been sent to the recluiter..."); ?>" />
			<?php
				echo formInput(array( 
				"id" => "jemail",
				"name" => "jemail",
				"pattern" => "^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$",
				"type" => "email",
				"class" => "span5 required",
				"field" => __("Email"), 
				"p" => "true", 
				"placeholder" => __("Enter your email"),
				"required" => "true"
			));

				echo formTextarea(array(
				"id" => "message",
				"name" => "message", 
				"class" => "span5 required",
				"rows" => "5",
				"field" => __("Message"), 
				"p" => "true",
				"placeholder" => __("Writte a message to the user"),
			));

				echo formInput(array(
				"type" => "button", 
				"id" => "apply",
				"name" => "apply",
				"value" => __("Apply for the vacancy"),
				"p" => "true"
			)); ?>

			<?php } ?>
		</p>
	</p>

	<br />
	<br />

	<?php
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
	<p>
		<?php echo fbComments($URL); ?>
	</p>
	
	<p>
		<a href="<?php echo path("jobs"); ?>">&lt;&lt; <?php echo __("Go back"); ?></a>
	</p>
</div>
