<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class review_ajax extends object_class{
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
        $_w['Review'] = '' ;
        $_w['Review Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Reviews');
    }

public function deleteReview(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id= intval($_POST['id']);

       $sql2="DELETE FROM review WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['Review']),$id,($_e['Review Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}


    public function bannersSort(){
        $list= htmlspecialchars($_POST['album']);
        for ($i = 0; $i < count($list); $i++) {
            $sql3="UPDATE `banners` SET sort='$i' WHERE `id`='$list[$i]'";
            $data=$this->dbF->setRow($sql3);
        }
    }


}
?>