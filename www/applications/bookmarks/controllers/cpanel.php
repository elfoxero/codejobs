<?php
if (!defined("ACCESS")) {
	die("Error: You don't have permission to access here...");
}

class CPanel_Controller extends ZP_Load 
{
	private $vars = array();

	public function __construct()
	{
		$this->app("cpanel");
		$this->application = "bookmarks";
		$this->CPanel = $this->classes("cpanel", "CPanel", null, "cpanel");
		$this->isAdmin = $this->CPanel->load();
		$this->vars = $this->CPanel->notifications();
		$this->CPanel_Model = $this->model("CPanel_Model");
		$this->Templates = $this->core("Templates");
		$this->Templates->theme("cpanel");
	}

	public function index()
	{
		if ($this->isAdmin) {
			redirect("cpanel");
		} else {
			$this->login();
		}
	}

	public function check()
	{
		if (POST("trash") and is_array(POST("records"))) {
			foreach (POST("records") as $record) {
				$this->trash($record, true); 
			}

			redirect("$this->application/cpanel/results");
		} elseif (POST("restore") and is_array(POST("records"))) {
			foreach (POST("records") as $record) {
				$this->restore($record, true); 
			}

			redirect("$this->application/cpanel/results");
		} elseif (POST("delete") and is_array(POST("records"))) {
			foreach (POST("records") as $record) {
				$this->delete($record, true); 
			}

			redirect("$this->application/cpanel/results");
		}

		return false;
	}

	public function delete($ID = 0, $return = false)
	{
		if (!$this->isAdmin) {
			$this->login();
		}
		
		if ($this->CPanel_Model->delete($ID)) {
			if ($return) {
				return true;
			}

			redirect("$this->application/cpanel/results/trash");
		} else {
			if ($return) {
				return false;
			}

			redirect("$this->application/cpanel/results");
		}
	}

	public function restore($ID = 0, $return = false)
	{ 
		if (!$this->isAdmin) {
			$this->login();
		}
		
		if ($this->CPanel_Model->restore($ID)) {
			if ($return) {
				return true;
			}

			redirect("$this->application/cpanel/results/trash");
		} else {
			if ($return) {
				return false;
			}

			redirect("$this->application/cpanel/results");
		}
	}

	public function trash($ID = 0, $return = false)
	{
		if (!$this->isAdmin) {
			$this->login();
		}

		if ($this->CPanel_Model->trash($ID)) {
			if ($return) {
				return true;
			}

			redirect("$this->application/cpanel/results");
		} else {
			if ($return) {
				return false;
			}

			redirect("$this->application/cpanel/add");
		}
	}

	public function add() 
	{
		if (!$this->isAdmin) {
			$this->login();
		}

		$this->title("Add");
		$this->helper("forms");
		$this->CSS("forms", "cpanel");
		$Model = ucfirst($this->application) ."_Model";
		$this->$Model = $this->model($Model);

		if (POST("save")) {
			$save = $this->$Model->cpanel("save");

			$this->vars["alert"] = $save;
		} elseif (POST("cancel")) {
			redirect("cpanel");
		}

		$this->vars["view"] = $this->view("add", true, $this->application);
		$this->render("content", $this->vars);
	}

	public function edit($ID = 0)
	{
		if (!$this->isAdmin) {
			$this->login();
		}

		if ((int) $ID === 0) {
			redirect($this->application ."/cpanel/results");
		}

		$this->title("Edit");
		$this->CSS("forms", "cpanel");
		$this->helper("forms");
		$Model = ucfirst($this->application) ."_Model";
		$this->$Model = $this->model($Model);

		if (POST("edit")) {
			$this->vars["alert"] = $this->$Model->cpanel("edit");
		} elseif (POST("cancel")) {
			redirect("cpanel");
		}

		$data = $this->$Model->getByID($ID);
		
		if ($data) {
			$this->vars["data"] = $data;
			$this->vars["view"] = $this->view("add", true, $this->application);
			
			$this->render("content", $this->vars);
		} else {
			redirect($this->application ."/cpanel/results");
		}
	}

	public function login() 
	{
		$this->title("Login");
		$this->CSS("login", "users");

		if (POST("connect")) {
			$this->Users_Controller = $this->controller("Users_Controller");
			$this->Users_Controller->login("cpanel");
		} else {
			$this->vars["URL"] = getURL();
			$this->vars["view"] = $this->view("login", true, "cpanel");
		}

		$this->render("include", $this->vars);
		$this->rendering("header", "footer");
		exit;
	}

	public function results()
	{
		if (!$this->isAdmin) {
			$this->login();
		}

		$this->check();
		$this->title("Manage ". $this->application);
		$this->CSS("results", "cpanel");
		$this->CSS("pagination");
		$this->js("checkbox");

		$trash = (segment(3, isLang()) === "trash") ? true : false;
		
		$this->vars["total"] = $this->CPanel_Model->total($trash);
		$this->vars["tFoot"] = $this->CPanel_Model->records($trash, "ID_Bookmark DESC");
		$this->vars["message"] = (!$this->vars["tFoot"]) ? "Error" : null;
		$this->vars["pagination"] = $this->CPanel_Model->getPagination($trash);
		$this->vars["trash"] = $trash;
		$this->vars["search"] = getSearch();
		$this->vars["view"] = $this->view("results", true, $this->application);
		
		$this->render("content", $this->vars);
	}

	public function activate($id = 0, $author = null)
	{
		if ($id > 0 and !is_null($author)) {
			$this->Users_Model = $this->model("Users_Model");
			$edit = $this->Users_Model->isAllow("edit");

			if ($edit) {
				$Model = ucfirst($this->application) ."_Model";
				$this->$Model = $this->model($Model);

				if ($this->$Model->activate($id)) {
					$vars["data"] = 1;
					
					$this->Cache = $this->core("Cache");
					$this->Cache->removeAll("bookmarks");
					$this->Cache->remove("profile-$author", "users");
				} else {
					$vars["data"] = 0;
				}

				$this->view("activate", $vars, $this->application);
			}
		}
	}
}