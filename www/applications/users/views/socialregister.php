<?php
if (!defined("ACCESS")) {
	die("Error: You don't have permission to access here...");
}

$socialUser = SESSION("socialUser");
$service    = recoverPOST("service", $socialUser["service"]);
$username   = recoverPOST("username", $socialUser["username"]);
$email      = recoverPOST("email", $socialUser["email"]);
$name       = recoverPOST("name", $socialUser["name"]);
$avatar     = recoverPOST("avatar", $socialUser["avatar"]);
$birthday   = recoverPOST("birthday", $socialUser["birthday"]);
$serviceID  = recoverPOST("serviceID", $socialUser["serviceID"]);

echo div("new-user", "class");
	echo formOpen(path("users/register/$service"), "form", "form");
		echo p(__("Join today to") ." ". _get("webName"), "resalt");

		if (!isset($alert) and SESSION("UserRegistered") and !POST("register")) {
			redirect();
		} else {
			if (POST("register") and SESSION("UserRegistered")) {
				echo getAlert(__("You can't register many times a day"));
			} else { 
				echo isset($alert) ? $alert : null;
			}
		}

		if (!isset($inserted) or !$inserted) {
			if (!SESSION("UserRegistered")) {
				?>
				<p><?php echo img($avatar, array("class" => "dotted")); ?> <strong><?php echo __("Hi"); ?></strong>, <?php echo $name; ?>!</p>
				<?php
				echo formInput(array(
					"id"       => "username",
					"name"     => "username",
					"class"    => "required", 
					"field"    => __("Username"), 
					"p"        => true, 
					"value"    => $username,
					"required" => true
				));

				echo formInput(array(
					"name"        => "email",
					"pattern"     => "^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$",
					"type"        => "email",
					"field"       => __("Email"), 
					"p"           => true, 
					"value"       => $email,
					"required"    => true,
					"placeholder" => __("Please, write your email")
				));

				echo formInput(array(
					"name"  => "name",
					"value" => $name,
					"type"  => "hidden"
				));

				echo formInput(array(
					"name"  => "avatar",
					"value" => $avatar,
					"type"  => "hidden"
				));

				echo formInput(array(
					"name"  => "birthday",
					"value" => $birthday,
					"type"  => "hidden"
				));

				echo formInput(array(
					"name"  => "serviceID",
					"value" => $serviceID,
					"type"  => "hidden"
				));
				
				echo formInput(array(
					"name"  => "register",
					"type"  => "submit",
					"class" => "submit",
					"value" => __("Create my account")
				));
			}
		}

	echo formClose();
echo div(false);