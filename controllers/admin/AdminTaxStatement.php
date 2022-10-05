<?php
# /modules/taxstatement/controllers/admin/AdminTaxStatement.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days 
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

// You can now access this controller from /your_admin_directory/index.php?controller=AdminTaxStatement
class AdminTaxStatementController extends ModuleAdminController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function renderList()
	{
		$html = '<h1>Hello Admin </h1>';
		
		$list = parent::renderList();
		
		// You can create your custom HTML with smarty or whatever then concatenate your list to it and serve it however you want !
		return $html . $list;
	}
}

