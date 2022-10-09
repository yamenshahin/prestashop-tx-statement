<?php
# /modules/taxstatement/models/TaxStatement.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

class TaxStatementModel extends ObjectModel
{
	/** Your fields names, adapt to your needs */
	public $id;
	public $user_id;
	public $date ;
	public $total_order;
	public $total_commission;
	public $total_shipping_rate;
	public $total_payable;
	public $status;
	public $transaction;
	public $commission_invoice;
	public $statement_invoice;
	public $from_id_seller_commission;
	public $to_id_seller_commission;

	/** Your table definition, adapt to your needs */
	public static $definition = [
		'table' => 'tax_statement',
		'primary' => 'id',
		'fields' => [
			'user_id' => [
				'type' => self::TYPE_INT,
				'validate' => 'isUnsignedInt',
				'size' => 10,
				'required' => true,
			],
			'date' => [
				'type' => self::TYPE_DATE,
				'validate' => 'isDate',
				'required' => true,
			],
			'total_order' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'total_commission' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'total_shipping_rate' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'total_payable' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'status' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'transaction' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'commission_invoice' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'statement_invoice' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'from_id_seller_commission' => [
				'type' => self::TYPE_INT,
				'validate' => 'isUnsignedInt',
				'size' => 11,
				'required' => true,
			],
			'to_id_seller_commission' => [
				'type' => self::TYPE_INT,
				'validate' => 'isUnsignedInt',
				'size' => 11,
				'required' => true,
			],
		],
	];

	/** Create your table into database, adapt to your needs */
	public static function installSql()
	{
		$tableName = _DB_PREFIX_ . self::$definition['table'];
		$primaryField = self::$definition['primary'];

		$sql = "
			CREATE TABLE IF NOT EXISTS `{$tableName}` (
				`{$primaryField}` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`user_id` int(10) unsigned NOT NULL,
				`date` date NOT NULL,
				`total_order` varchar(256) NOT NULL,
				`total_commission` varchar(256) NOT NULL,
				`total_shipping_rate` varchar(256) NOT NULL,
				`total_payable` varchar(256) NOT NULL,
				`status` varchar(256) NOT NULL,
				`transaction` varchar(256) NOT NULL,
				`commission_invoice` varchar(256) NOT NULL,
				`statement_invoice` varchar(256) NOT NULL,
				`from_id_seller_commission` int(11) unsigned NOT NULL,
				`to_id_seller_commission` int(11) unsigned NOT NULL,
				PRIMARY KEY (`{$primaryField}`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		
		// Add tax_status col to ets_mp_seller_commission table
		$sql2 = "DESCRIBE "._DB_PREFIX_."ets_mp_seller_commission";	
		$columns = Db::getInstance()->executeS($sql2);
		$found = false;
		foreach($columns as $col){
			if($col['Field']=='tax_status'){
				$found = true;
				break;
			}
		}
		if(!$found){
			Db::getInstance()->execute("ALTER TABLE "._DB_PREFIX_."ets_mp_seller_commission ADD tax_status tinyint(1) DEFAULT 0");
		}

		// Add tax_status col to ets_mp_seller_commission table
		return Db::getInstance()->execute($sql);
	}
}

