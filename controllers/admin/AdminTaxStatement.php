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
        
        $output = $this->context->smarty->fetch($this->module->getLocalPath() .
        'views/templates/admin/admin-template.tpl');
		$list = parent::renderList();
        return $output. $list ;
    }
}

