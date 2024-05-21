<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class rota_ajax extends object_class{
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
        //ajax class
        $_w['Delete'] = '' ;
        $_w['Shift Management'] = '' ;
        $_w['Shift Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin userevent');
    }

public function deleteshift(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=$_POST['id'];

       $sql2="DELETE FROM shift WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['Shift Management']),$id,($_e['Shift Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}

public function deleterota(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=$_POST['id'];
        $from=$_POST['from'];
        $to=$_POST['to'];

       $sql2="DELETE FROM record WHERE userId= ?  AND date BETWEEN ? AND  ? ";
       $this->dbF->setRow($sql2,array($id,$from, $to),false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),('Rota Management'),$id,('Rota Delete Successfully'));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}

}
?>