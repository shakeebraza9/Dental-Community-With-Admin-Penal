<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class webinar_ajax extends object_class{
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
        //Ajax class
        $_w['Delete'] = '' ;
        $_w['Webinar'] = '' ;
        $_w['Webinar Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Webinar Management');
    }

public function deleteWebinar(){
    global $_e;
    try{
        $this->db->beginTransaction();

        $id=$_POST['id'];

        $sql3="SELECT image,presented_image FROM webinar WHERE id= ? ";
        $data=$this->dbF->getRows($sql3,array($id));
        foreach($data as $key=>$val){
            $this->functions->deleteOldSingleImage($val['image']);
            $this->functions->deleteOldSingleImage($val['presented_image']);

        }

        $sql2="DELETE FROM webinar WHERE id='$id'";
        $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['Webinar']),$this->dbF->rowLastId,($_e['Webinar Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}


}
?>