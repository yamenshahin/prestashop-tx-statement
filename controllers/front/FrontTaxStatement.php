<?php
# /modules/taxstatement/controllers/front/FrontTaxStatement.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

// You can now access this controller from /index.php?fc=module&module=taxstatement&controller=FrontTaxStatement
class FrontTaxStatementController extends ModuleFrontController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function initContent()
	{
		$this->context->smarty->assign([
			'greetingsFront' => 'Hello Front from Tax Statement !',
		]);

		$this->setTemplate('my-front-template.tpl');
		// Don't forget to create /modules/taxstatement/views/templates/front/my-front-template.tpl

		parent::initContent();
	}
}

