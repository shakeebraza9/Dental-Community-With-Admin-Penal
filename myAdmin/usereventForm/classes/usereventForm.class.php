<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class usereventForm extends object_class{
    public $productF;
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
        //Index
        $_w['User Event Forms'] = '' ;
        //filesManagerEdit.php
        $_w['Manage User Event Forms'] = '' ;

        //filesManager.php
        $_w['Active Event'] = '' ;
        $_w['Draft User Event Forms'] = '' ;
        $_w['Add New User Event Forms'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Event Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image User Event Forms  Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['User Event Forms'] = '' ;
        $_w['Added'] = '' ;
        $_w['User Event Forms Add Successfully'] = '' ;
        $_w['User Event Forms Add Failed'] = '' ;
        $_w['User Event Forms Update Failed'] = '' ;
        $_w['User Event Forms Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['File'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old User Event Forms Image'] = '' ;
        $_w['USER'] = '' ;
        $_w['mail'] = '' ;
        $_w['Products'] = '' ;
        $_w['User'] = '' ;
        $_w['Products'] = '' ;
        $_w['Due Date'] = '' ;
        $_w['Mandatory'] = '' ;
        $_w['Non Mandatory'] = '' ;
        $_w['Assign To'] = '' ;
        $_w['One User'] = '' ;
        $_w['All User'] = '' ;
        $_w['Category'] = '' ;
        $_w['Type'] = '' ;
        $_w['Description'] = '' ;
        $_w['Approved'] = '' ;
        $_w['Yes'] = '' ;
        $_w['No'] = '' ;
        $_w['Active User Event Forms'] = '' ;
        $_w['Completion Date'] = '' ;
        $_w['Expiry Date'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Type'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin eventForm');

    }


    public function usereventFormView(){
        $sql  = "SELECT * FROM usereventForms ORDER BY ID DESC LIMIT  5000";
        $data =  $this->dbF->getRows($sql);
        $this->usereventFormPrint($data);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM eventmanagement WHERE id=  ? ";
        $data =  $this->dbF->getRow($sql,array($id));
        return $data[0];
    }
    
    public function question($id){
        $sql  = "SELECT question FROM eventForms WHERE id= ? ";
        $data =  $this->dbF->getRow($sql,array($id) );
        return $data[0];
    }

    public function userName($id){
        $sql = "SELECT acc_name FROM accounts_user WHERE acc_id= ? ";
        $data = $this->dbF->getRow($sql,array($id));
        return $data[0];
    }

    public function usereventFormPrint($data){
        global $_e;
       $uniq=uniqid('id');
        $href = 'usereventForm/usereventForm_ajax.php?page=active_usereventForm';

            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Event Title']) .'</th>
                        <th>USER NAME</th>
                        <th>QUESTION</th>
                        <th>RADIO</th>
                        <th>DATE</th>
                        <th>TiME</th>
                        <th>FIELD 1</th>
                        <th>FIELD 2</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        // foreach($data as $val){
        //     $i++;
        //     $id = $val['id'];
        //     $download = '';
        //     echo "<tr>
        //             <td>$i</td>
        //             <td>".$this->titleName($val['title_id'])."</td>
        //             <td>".$this->userName($val['user'])."</td>
        //             <td>".$this->question($val['q_id'])."</td>
        //             <td>$val[radio]</td>
        //             <td>$val[date]</td>
        //             <td>$val[time]</td>
        //             <td>$val[field1]</td>
        //             <td>$val[field2]</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>
        //                     <!--<a data-id='$id' href='-usereventForm?page=edit&eventId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>-->
        //                     <a data-id='$id' onclick='deleteusereventForm(this);' class='btn'>
        //                         <i class='glyphicon glyphicon-trash trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>
        //                 </div>
        //             </td>
        //           </tr>";
        // }

        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }



}
?>