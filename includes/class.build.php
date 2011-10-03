<?php

/*

Main template build class for this framework. The template functions (template.php) should really be used instead of this class as they accomplish all that you need.

*/

class Build
{
	public $page;
	
	function Build()
	{
		$this->page = (isset($_GET['page'])) ? trim($_GET['page']) : '';
		$disallowed = array('header', 'footer', 'sidebar', 'functions');
		
		if($this->page == 'ajax') $this->page == 'ajax';
		elseif(!empty($this->page) && (!file_exists(CNTPATH . $this->page . '.php') || in_array($this->page, $disallowed))) $this->page = '404';
		elseif(empty($this->page)) $this->page = 'index';
		
		$current = ($this->page == 'index') ? 'home' : $this->page;
		define('CURRENT_PAGE', $current);
	}
	
	public function page()
	{
		$this->load($this->page . '.php', array());
	}
	
	public function load($file = '', $metas)
	{
		global $db, $auth, $f, $img, $meta, $facebook;
		$meta = array_merge($meta, $metas);
		if($file == 'ajax.php') require(ABSPATH . $file);
		elseif(file_exists(CNTPATH . $file)) require(CNTPATH . $file);
		else die('FAIL: Template file "' . $file . '" not found!');
	}
}