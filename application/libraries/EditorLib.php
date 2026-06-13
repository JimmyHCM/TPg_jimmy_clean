<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class EditorLib {
     
    private $CI = null;
     
    function __construct()
    {
        $this->CI = &get_instance();
    }   
 
 /*
    public function initDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';

        //Pass the database object to the model
        $this->CI->DemoStaffModel->init($db);
    }
    */
    
    public function initDB ()
    {   

        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->SummaryModel->init($db);
    }
    
    public function initBatchStatusDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->BatchStatusModel->init($db);
    }

    public function initReviewOLstatusDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->ReviewStatusModel->init($db);
    }

    public function initChinaDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->ChinaProjUniModel->init($db);
    }
    
    public function initCurriculumDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->CurriculumModel->init($db);
    }
    
    public function initPortalDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->PortalUserModel->init($db);
    }

    public function initVariationDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->VariationModel->init($db);
    }

    public function initColorCodeDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->ColorCodeModel->init($db);
    }

    public function initTextCodeDB ()
    {   
        // DataTables PHP library
        require_once dirname(__FILE__).'/editor-2.0.7/DataTables.php';
                  
        //Pass the database object to the model
        $this->CI->LongTextCodeModel->init($db);
    }

}

?>