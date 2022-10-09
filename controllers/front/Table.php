<?php
# /modules/taxstatement/controllers/front/Table.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days 
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

// You can now access this controller from /index.php?fc=module&module=taxstatement&controller=Table
class TaxStatementTableModuleFrontController extends ModuleFrontController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function initContent()
	{
		
		$this->createTaxStatements();
		$taxStatements = $this->getTaxStatements($this->context->customer->id);
		$this->context->smarty->assign([
			'taxStatements' => $taxStatements,
		]);

		$this->setTemplate('module:taxstatement/views/templates/front/table-template.tpl');
		// Don't forget to create /modules/taxstatement/views/templates/front/table-template.tpl
		parent::initContent();
	}

	public function getTaxStatements($idUser){
		$sql = "SELECT * FROM "._DB_PREFIX_."tax_statement
				WHERE user_id = ".$idUser."
		";
		
		$taxStatements = Db::getInstance()->executeS($sql);
		return $taxStatements;
	}
	// Create tax statements
	public function createTaxStatements(){

		
		$sellerCommissionsGroupByUserID = $this->getSellerCommissionsGroupByUserID();
		$taxStatements = [];
		foreach($sellerCommissionsGroupByUserID as $idUser => $commissions) {
			array_push($taxStatements, $this->createSingleTaxStatement($idUser, $commissions));
		}
		$this->storeTaxStatements($taxStatements);

		// update tax status
		foreach($taxStatements as $taxStatement) {
			$this->setTaxStatus(
				1, 
				$taxStatement['from_id_seller_commission'], 
				$taxStatement['to_id_seller_commission'],
				$taxStatement['user_id']
			);
		}
		
	}

	public function getSellerCommissionsGroupByUserID() {

		$sql = "SELECT * FROM "._DB_PREFIX_."ets_mp_seller_commission
				WHERE tax_status = 0
		";
		
		$sellerCommissions = Db::getInstance()->executeS($sql);
		$commissions = [];
		// Group
		foreach ($sellerCommissions as $sellerCommission) {
			$commissions[$sellerCommission['id_customer']][] = $sellerCommission;
		}

		return $commissions;
	}

	public function createSingleTaxStatement($idUser, $commissions){
		$totalOrders = 0;
		$totalPayable = 0;
		$idsCommission = [];
		foreach($commissions as $commission){
			$totalOrders += $commission['total_price'];
			$totalPayable += $commission['commission'];
			array_push($idsCommission, $commission['id_seller_commission']);
		}
		return [
		'user_id' => $idUser,
		'total_order' => $totalOrders, 
		'date' => date("Y-m-d"),
		'total_commission' => $totalOrders - $totalPayable,
		'total_shipping_rate' => 0,
		'total_payable' => $totalPayable, 
		'status' => 'Ready for payment',
		'transaction' => '',
		'commission_invoice' => '',
		'statement_invoice' => '', 
		'from_id_seller_commission' => $idsCommission[0],
		'to_id_seller_commission' => end($idsCommission)
		];
	}

	public function storeTaxStatements($taxStatements){
		Db::getInstance()->insert("tax_statement", $taxStatements);
	}

	public function setTaxStatus($taxStatus, $fromIdSellerCommission, $toIdSellerCommission, $idCustomer) {
		$sql = "
			UPDATE "._DB_PREFIX_."ets_mp_seller_commission
			SET tax_status = ".$taxStatus."
			WHERE 
			(id_seller_commission BETWEEN ".$fromIdSellerCommission." AND ".$toIdSellerCommission.")
			AND (id_customer = ".$idCustomer.")
		";
		Db::getInstance()->Execute($sql); 
	}
}

