<?php
require_once(__DIR__ . "/../../global_ajax.php"); //connection setting db
class ticket_ajax extends object_class
{
    public function __construct()
    {
        parent::__construct('3');

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w = array();
        $_w["Delete WebUser"]    =   "";
        $_w["Update WebUser"]    =   "";
        $_w["WebUser Update Successfully"]    =   "";
        $_w["WebUser Delete Successfully"]    =   "";
        $_w["WebUser"]    =   "";
        $_w["Delete AdminUser"]    =   "";
        $_w["Delete UserGroup"]    =   "";
        $_w["Admin User Group"]    =   "";
        $_w["Admin User Group Delete Successfully"]    =   "";
        $_w["AdminUser Update Successfully"]    =   "";
        $_w["AdminUser"]    =   "";
        $_w["Update AdminUser"]    =   "";
        $_w["AdminUser Delete Successfully"]    =   "";
        $_e    =   $this->dbF->hardWordsMulti($_w, $adminPanelLanguage, "Users Management");
    }

    public function UserDelete()
    {
        global $_e;
        try {
            $this->db->beginTransaction();
            $id = $_POST['id'];

            $sql2 = "DELETE FROM `clients` WHERE c_id = '$id'";
            $this->dbF->setRow($sql2, false);
            if ($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Delete WebUser']), _uc($_e['WebUser']), $id, _uc($_e['WebUser Delete Successfully']));
        } catch (PDOException $e) {
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }
}