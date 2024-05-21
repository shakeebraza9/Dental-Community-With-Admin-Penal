<?php 
include_once("global.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}
                       if ($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == '0') {
                          $user  = $_SESSION['superid'];
                        }else{
                          $user = $_SESSION['currentUser'];
                        }
                            
                            
                            // $sql1 = "SELECT * FROM `accounts_user` WHERE (`acc_id` ='$user' AND `acc_type`='1' )";
                            // $data1 = $dbF->getRow($sql1);
 
?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            COVID Screening
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side">
            <div class="form-group">
                <h2> <?php  echo htmlspecialchars($_GET['category']) . " Report </h2> "; ?><div><a target='_blank' style="float: right;font-weight: bold;" href='<?php echo $_SERVER['PHP_SELF']?>?category=<?php echo htmlspecialchars($_GET['category'])?>&excel=1'>Download as Excel</a></div>
                    <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>
            <div class="cpd-table">
                <div class="cpd-tbl datable">
                    <table id="policy_report">
                        <thead>
                            <tr>
                                <th>Name of Employee</th>
                                <th>Role</th>
                                <?php
                                    if($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == '0'){
                                    $user = $_SESSION['superid'];  
                                    }
                                    else{
                                    $user = $_SESSION['currentUser'];
                                    }
                                    $category = htmlspecialchars($_GET['category']);
                                    $userId = "all:".$_SESSION['currentUser'];
                                    //echo "<h1>" . $userId . "</h1>";
                                    $titles = array(); 
                                    $dates  = array();
                                    $sql  = "SELECT title,id,expiry FROM documents WHERE assignto IN('all:$_SESSION[currentUser]','all') AND category = '$category' ";
                                    $data = $dbF->getRows($sql);
                                    foreach($data as $key => $value){
                                        array_push($titles,$value['id']);
                                        echo "<th style='text-align: center; vertical-align: middle;'> <br> ". $value['title'] ." <br> </th>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php
                           
                            $SuperUserAccess = $dbF->getRow("SELECT allow FROM superUser WHERE user='$user' AND type='superuser_access'");
                            $SuperUserAccess = $SuperUserAccess['allow'];
                            if(($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == 'full')   || $_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice'){
                            $user = $_SESSION['currentUser'];
                            }else
                            {
                            $user = $_SESSION['superid'];  
                            }
                            
                            $tempArr  = array();
                          
                            
                           
                            
                            // creating user 
                            $sql  = "SELECT * FROM `accounts_user` WHERE  (`acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under'))  AND`acc_type`='1'";
                            $data = $dbF->getRows($sql);
                            $userArr = array();
                            foreach($data as $userData){
                                
                               $userId = $userData['acc_id'];
                                $data2 =  $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userId' AND `setting_name`='role'");
                                    $role = $data2[0];
                                    if(empty($role)){
                                        $role='--';
                                    }
                                    $userArr[$userId] = array_merge($userData, array('role'=>$role));
                                    
                            }
                            
                            
                            // Creating distinct user
                             $sql4  = "SELECT 
                                      DISTINCT user
                                    FROM userdocuments_view 
                                    WHERE (acc_under = $user or user = $user) and assignto IN('all:$user','all') and category = '$category'
                                    ORDER BY user ASC"
                                    ;
                            $data4 = $dbF->getRows($sql4);
                            foreach($data4 as $key => $val){
                                $userId=$val['user'];
                                $sql5  = "SELECT 
                                      DISTINCT title_id
                                    FROM userdocuments_view 
                                    WHERE (acc_under = $user or user = $user) and assignto IN('all:$user','all') and category = '$category'
                                    ORDER BY user ASC"
                                    ;
                                 $data5 = $dbF->getRows($sql5);
                                  
                                  $temp__ = array();
                                  foreach($data5 as $key1=>$val1){
                                      $t_id = $val1['title_id'];
                                      $sql6 = "SELECT 
                                        user, DATE_FORMAT(`completion_date`,'%d-%b-%Y') as completion_date, DATE_FORMAT(`expiry_date`,'%d-%b-%Y') as expiry_date, status, title_id, file 
                                    FROM userdocuments_view 
                                    WHERE ( user = $userId)  AND category = '$category'  AND title_id = '$t_id'
                                    ORDER BY title_id asc";
                                    $data6 = $dbF->getRows($sql6);
                                    $temp__[$t_id] = $data6;
                                    
                                  }
                                  $tempArr[$userId] = array($temp__);
                            }
                            ?>
                                <script>
                                
                                    
                                    // document data
                                    let data = '<?php echo json_encode($tempArr) ?>';
                                    data = JSON.parse(data);
                                    // user data
                                    let userData = '<?php echo json_encode($userArr) ?>';
                                    userData = JSON.parse(userData);
                                    //title
                                    let titleData = '<?php echo json_encode($titles) ?>';
                                    titleData = JSON.parse(titleData);
                                    //Category
                                    let category  = '<?php echo $category ?>';
                                    
                                   
                                     
                                    let temp={}
                                    const users = Object.keys(data)
                                    console.log(users,data);

                                    users.map((user,item)=>{
                                        
                                        let titleTem = {}
                                        let titles    =Object.keys(data[user][0])
                                      
                                        titles.map((title, items)=>{
                                            let temDoc = []
                                            let doc_data =  data[user][0][title]
                                            if(doc_data.length === 0 || doc_data.length === 1){
                                                titleTem[title] = doc_data
                                            }else{
                                                     const groupByStatus = doc_data.reduce((group, item) => {
                                                      const { status } = item;
                                                      group[status] = group[status] ?? [];
                                                      group[status].push(item);
                                                      return group;
                                                    }, {});
                                                if('complete' in groupByStatus){
                                                    let completeData = groupByStatus['complete'];
                                                    let sortedData = completeData.sort(function(a,b){
                                                      
                                                      return new Date(b.expiry_date) - new Date(a.expiry_date);
                                                    });
                                                    titleTem[title] = [sortedData[0]]
                                                }else if('expire' in groupByStatus){
                                                  let expireData = groupByStatus['expire'];
                                                  let sortedData = expireData.sort(function(a,b){

                                                      return new Date(b.expiry_date) - new Date(a.expiry_date);
                                                    });
                                                     titleTem[title] = [sortedData[0]]
                                                }
                                            }
                                        })
                                        temp[user] = titleTem
                                    })
                             

                                        var tableRef = document.getElementById('policy_report').getElementsByTagName('tbody')[0];

                                        Object.keys(temp).map((item, index)=>{
                                           
                                            let single_row = temp[item];
                                            let title_ids = Object.keys(single_row)
                                            let cur_user_row = userData[item];
                                            let {acc_id,acc_name, role }  = cur_user_row
                                            
                                            var row = table.insertRow(index+1);
                                            var row   = tableRef.insertRow(tableRef.rows.length);
                                            
                                            var cell1 = row.insertCell(0);
                                            var cell2 = row.insertCell(1);
                                            cell1.outerHTML = `<td>${acc_name}</td>`;
                                            cell2.outerHTML = `<td>${role}</td>`;
                                            
                                            titleData.map( (title_item, title_key)=>{
                                                
                                                let doument_data = single_row[title_item]
                                                let cellno  = title_key + 2
                                                let cell = row.insertCell(cellno);
                                                
                                                if(doument_data === undefined ){
                                                    cell.outerHTML = `<td style='color:#FF6347; text-align: center; vertical-align: middle;'>
                                                                        Due <br>
                                                                         <i class='fas fa-times' style='color:#FF6347;'></i>
                                                                    </td>`;
                                                }
                                                else if(doument_data.length===0 ){
                                                    
                                                    cell.outerHTML = `<td style='color:#FF6347; text-align: center; vertical-align: middle;'>
                                                                        Due <br>
                                                                         <i class='fas fa-times' style='color:#FF6347;'></i>
                                                                    </td>`;
                                                  
                                                }else{
                                                    
                                                    doument_data = doument_data[0];
                                                    
                                                   if(category=='Recruitment' || category=='Signed Policies' || category=='Minute Meeting' || category=='MHRA'){
                                                        if(category=='Recruitment'){
                                                            let {completion_date, file} = doument_data
                                                         cell.outerHTML = `<td style='color:#3CB371; text-align: center; vertical-align: middle;'>${completion_date}<br><a href='${file}' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a></td>`;
                                                        }else{
                                                            let {completion_date, file} = doument_data
                                                            cell.outerHTML = `<td style='color:#3CB371; text-align: center; vertical-align: middle;'>${completion_date}<br><a href='${file}' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a><br>Signed</td>`; 
                                                        }   
                                                   }else{
                                                      let {expiry_date, file, completion_date, status, title_id, user} = doument_data;
                                                        
                                                      let color =               (status == 'complete') ? '#3CB371' : '#ff6347';
                                                      let tempStatus =          (status == 'complete') ? completion_date : 'Expired on';
                                                      let icon =                (status == 'complete') ? `<i class='fas fa-check' style='color:#3CB371;'></i>`:`<i class='fas fa-times' style='color:#ff6347;'></i>`;
                                                      let expire_date_status =  (status == 'complete') ? '' : (expiry_date !== null) ? expiry_date : "";
                                                      
                                                      cell.outerHTML = `<td style='color:${color}; text-align: center; vertical-align: middle;'>
                                                      ${tempStatus}<br>
                                                      <a href='${file}' target='_blank'>
                                                        ${icon}
                                                      </a><br>
                                                      ${expire_date_status}<br>
                                                
                                                      </td>`;
                                                   }
                                                }
                                                
                                                
                                                
                                            } )
                                            
                                         
                                    })
                                   $( document ).ready(function() {
                                       console.log("After loading ")
                                         $('.datable table').DataTable();
                                   })

                                </script>
                            
                           
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
  
</script>
<?php include_once('footer.php');  ?>
