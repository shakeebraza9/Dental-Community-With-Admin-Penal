<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class terms_ajax extends object_class{
    public function __construct(){
        parent::__construct('3');

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w=array();
        $_w['Delete'] = '' ;
        $_w['Terms'] = '' ;
        $_w['Terms Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Terms');
    }

public function deleteTerms(){
    global $_e;
    try{
        $this->db->beginTransaction();

        $id=intval($_POST['id']);
        $sql2="DELETE FROM term_and_condition WHERE id= ? ";
       $this->dbF->setRow($sql2,array($id));
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(_uc($_e['Delete']),_uc($_e['Terms']),$id,($_e['Terms Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}


}
?>