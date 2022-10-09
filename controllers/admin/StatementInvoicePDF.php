<?php
# /modules/taxstatement/controllers/admin/TaxStatementPDF.php

/**
 * Tax Statement - A Prestashop Module
 * 
 * Mkayn custom module that display tax statements every 14-15 days 
 * 
 * @author Yamen Shahin <yamenshahin@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;


class StatementInvoicePDFController extends ModuleAdminController {

    public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

    public function renderList()
    {
        $this->generatePDF();
        
        $output = $this->context->smarty->fetch($this->module->getLocalPath() .
        'views/templates/admin/admin-template.tpl');
		$list = parent::renderList();
        return $output. $list ;
    }

    public function getContent() {

        $this->context->smarty->assign(
            array(
                'content' => 'Statement Invoice',
            )
        );

        return $this->context->smarty->fetch($this->module->getLocalPath() .
            'views/templates/admin/admin-pdf-statement-invoice-template.tpl');
    }

    public function getHeader() {

        $this->context->smarty->assign(
            array(
                'header' => 'Statement Invoice',
            )
        );

        return $this->context->smarty->fetch($this->module->getLocalPath() .
            'views/templates/admin/admin-pdf-header-template.tpl');
    }

    public function getFooter() {

        $this->context->smarty->assign(
            array(
                'footer' => 'Statement Invoice',
            )
        );

        return $this->context->smarty->fetch($this->module->getLocalPath() .
            'views/templates/admin/admin-pdf-footer-template.tpl');
    }

    public function getFilename() {

        return 'StatementInvoice-id.pdf';
    }

    public function getBulkFilename() {

        return 'StatementInvoice-id.pdf';
    }

    public function generatePDF(){
        $content = $this->getContent();
        $header = $this->getHeader();
        $footer = $this->getFooter();
        $fileName= $this->getFilename();
        $pdfGen = new PDFGenerator(false, 'P');
        $pdfGen->setFontForLang(Context::getContext()->language->iso_code);
        $pdfGen->startPageGroup();
        $pdfGen->createHeader($header);
        $pdfGen->createFooter($footer);
        $pdfGen->createContent($content);
        $pdfGen->writePage();
        $pdfGen->render($fileName, 'D');
    }
}
