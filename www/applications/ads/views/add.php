<?php 
	if (!defined("ACCESS")) {
		die("Error: You don't have permission to access here...");
	}
	
	$ID  	   = isset($data) ? recoverPOST("ID", $data[0]["ID_Ad"]) : 0;
	$title     = isset($data) ? recoverPOST("title", $data[0]["Title"]) : recoverPOST("title");
	$banner    = isset($data) ? recoverPOST("banner", $data[0]["Banner"]) : null;
	$URL       = isset($data) ? recoverPOST("URL", $data[0]["URL"]) : "http://";
	$time 	   = isset($data) ? recoverPOST("time", $data[0]["Time"]) : recoverPOST("time");
	$situation = isset($data) ? recoverPOST("situation", $data[0]["Situation"]) : recoverPOST("situation");
	$end_date  = isset($data) ? recoverPOST("end_date", date("d/m/Y", $data[0]["End_Date"])) : recoverPOST("end_date", now(true));
	$principal = isset($data) ? recoverPOST("principal", $data[0]["Principal"]) : recoverPOST("principal");
	$edit      = isset($data) ? true : false;	
	$action	   = isset($data) ? "edit" : "save";
	$href	   = isset($data) ? path(whichApplication() ."/cpanel/$action/$ID/") : path(whichApplication() ."/cpanel/add/");

	echo div("add-form", "class");
		echo formOpen($href, "form-add", "form-add", null, "post", "multipart/form-data");
			echo p(__(ucfirst(whichApplication())), "resalt");
			
			echo isset($alert) ? $alert : null;

			echo formInput(array(
				"name" 	=> "title", 
				"class" => "span10 required", 
				"field" => __("Title"), 
				"p" 	=> true, 
				"value" => $title
			));
			
			if (isset($banner)) {
				$image = img(path($banner, true), array("alt" => "Banner", "class" => "no-border", "style" => "max-width: 780px;"));
			
				echo __("If you change the banner image, this image will be deleted") . "<br />";
				echo $image;
				echo formInput(array("name" => "banner", "type" => "hidden", "value" => $banner));
			} 

			echo formInput(array(
				"type" 	=> "file", 
				"name" 	=> "image", 
				"class" => "required", 
				"field" => __("Image"), 
				"p" 	=> true
			));
			
			echo formInput(array(
				"type" 	=> "url",
				"name" 	=> "URL", 
				"class" => "span10 required", 
				"field" => __("URL"), 
				"p" 	=> true, 
				"value" => $URL
			));

			$options = array(
				0 => array(
					"value"    => 1,
					"option"   => __("Yes"),
					"selected" => ((int) $principal === 1) ? true : false
				),		
				1 => array(
					"value"    => 0,
					"option"   => __("No"),
					"selected" => ((int) $principal === 0) ? true : false
				)
			);

			echo formSelect(array(
				"name" 	=> "principal", 
				"class" => "required", 
				"p" 	=> true, 
				"field" => __("Principal")), 
				$options
			);			
			
			$options = array(
				0 => array(
					"value"    => "Active",
					"option"   => __("Active"),
					"selected" => ($situation === "Active") ? true : false
				),				
				1 => array(
					"value"    => "Inactive",
					"option"   => __("Inactive"),
					"selected" => ($situation === "Inactive") ? true : false
				)
			);

			$months = array(__("January"), __("February"), __("March"), __("April"), __("May"), __("June"), __("July"), __("August"), __("September"), __("October"), __("November"), __("December"));

			echo formInput(array(
				"type"  => "text",
				"name" 	=> "end_date", 
				"class" => "span3 required jdpicker", 
				"field" => __("Expiration date"), 
				"p" 	=> true, 
				"value" => $end_date,
				"data-options" => '{"date_format": "dd/mm/YYYY", "month_names": ["'. implode('", "', $months) .'"], "short_month_names": ["'. implode('", "', array_map(create_function('$month', 'return substr($month, 0, 3);'), $months)) .'"], "short_day_names": ['. __('"S", "M", "T", "W", "T", "F", "S"') .']}'
			));

			echo formSelect(array(
				"name" 	=> "situation", 
				"class" => "required", 
				"p" 	=> true, 
				"field" => __("Situation")), 
				$options
			);			
			
			echo formAction($action);
			
			echo formInput(array("name" => "ID", "type" => "hidden", "value" => $ID));
		echo formClose();
	echo div(false);