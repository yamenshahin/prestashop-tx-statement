<?php
# /modules/taxstatement/taxstatement.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days 
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

// We look for our model since we want to install its SQL from the module install
require_once(__DIR__ . '/models/TaxStatement.php');

class TaxStatement extends Module
{
	const DEFAULT_CONFIGURATION = [
		// Put your default configuration here, e.g :
		// 'TAXSTATEMENT_BACKGROUND_COLOR' => '#eee',
	];

	public function __construct()
	{
		$this->initializeModule();
	}

	public function install()
	{
		return
			parent::install()
			&& $this->installTab()
			&& $this->initDefaultConfigurationValues()
			&& $this->registerHook('displayHeader')
			&& $this->registerHook('actionCustomerAccountAdd')
			&& TaxStatementModel::installSql()
		;
	}

	public function uninstall()
	{
		return
			parent::uninstall()
			&& $this->uninstallTab()
			&& $this->unregisterHook('displayHeader')
			&& $this->unregisterHook('actionCustomerAccountAdd')
		;
	}
	
	/** Example of a display hook, it's triggered by the header on the front office */
	public function hookDisplayHeader()
	{
		// You can add your module stylesheets from here
		$this->context->controller->addCSS($this->_path . 'views/css/taxstatement.css', 'all');
		// Don't forget to create /modules/taxstatement/views/css/taxstatement.css

		$this->context->smarty->assign([
			'greetings' => 'Hello from Tax Statement !',
		]);

		return $this->display(__FILE__, 'header.tpl');
		// Don't forget to create /modules/taxstatement/views/templates/hook/header.tpl
	}
		
	/** Example of an action hook, it's triggered when a customer signup successfully */
	public function hookActionCustomerAccountAdd($params)
	{
		// You can now retrieve the customer submitted informations with $params['_POST']
		// Or even get the new customer id with $params['newCustomer']->id
	}
		
	/** Module configuration page */
	public function getContent()
	{
		return 'Tax Statement configuration page !';
	}

	/** Initialize the module declaration */
	private function initializeModule()
	{
		$this->name = 'taxstatement';
		$this->tab = 'market_place';
		$this->version = '0.0.1';
		$this->author = 'Yamen Shahin';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = [
			'min' => '1.7',
			'max' => _PS_VERSION_,
		];
		$this->bootstrap = true;
		
		parent::__construct();

		$this->displayName = $this->l('Tax Statement');
		$this->description = $this->l('Mkayn custom module that display tax statements every 14-15 days ');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall this module ?');
	}

	/** Set module default configuration into database */
	private function initDefaultConfigurationValues()
	{
		foreach (self::DEFAULT_CONFIGURATION as $key => $value) {
			if (!Configuration::get($key)) {
				Configuration::updateValue($key, $value);
			}
		}

		return true;
	}

	/** Install module tab, to your admin controller */
	private function installTab()
	{
		$languages = Language::getLanguages();
		
		$tab = new Tab();
		$tab->class_name = 'AdminTaxStatement';
		$tab->module = $this->name;
		$tab->id_parent = (int)Tab::getIdFromClassName('DEFAULT');

		foreach ($languages as $lang) {
			$tab->name[$lang['id_lang']] = 'Tax Statement';
		}

		try {
			$tab->save();
		} catch (Exception $e) {
			return false;
		}

		return true;
	}

	/** Uninstall module tab */
	private function uninstallTab()
	{
		$tab = (int)Tab::getIdFromClassName('AdminTaxStatement');

		if ($tab) {
			$mainTab = new Tab($tab);

			try {
				$mainTab->delete();
			} catch (Exception $e) {
				echo $e->getMessage();

				return false;
			}
		}

		return true;
	}
}

