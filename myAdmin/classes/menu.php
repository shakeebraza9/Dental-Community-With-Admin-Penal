<?php

class menu extends object_class
{
    //If you want to hide menu for this Website, use
    //$this->checkActive('Dashboard','name',false) false in 2nd parameter in functions
    //same as subMenu functions

    public function __construct(){
        parent::__construct('3');
        global $_e;
        global $adminPanelLanguage;

        //Main Menu List
        $_w=array();
        $_w['Dashboard'] = '';
        $_w['Products'] = '';
        $_w['Stock Management']= '';
        $_w['Order Management']= '';
        $_w['Statics'] = '';
        $_w['Shipping Management'] = '';
        $_w['Menu'] = '';
        $_w['Logs Management']= '';
        $_w['Pages']= '';
        $_w['News & Events']= '';
        $_w['Webinar Management']= '';

        $_w['Sort Products Image']= '';
        $_w['Goods Transfer Note']= '';
        $_w['Inventory Adjustment Note']= '';
        $_w['Visiting Customers']= '';
        $_w['Sort Products Image']= '';
        $_w['Goods Transfer Note']= '';
        $_w['Inventory Adjustment Note']= '';
        $_w['Visiting Customers']= '';
        $_w['Webinar']= '';
        
        $_w['POST']= '';
        $_w['Post']= '';
        $_w['Add Post']= '';
        $_w['Clients Slider']= '';
        $_w['Banners']= '';
        // $_w['Reviews']= '';
        $_w['Slider']= '';
        $_w['Media']= '';
        $_w['SEO Management']= '';
        $_w['Setting']= '';
        $_w['Email Management']= '';
        $_w['Users']= '';
        $_w['Blog']= '';
        $_w['Products Boxes']= '';
        $_w['Brands Slider']= '';
        $_w['Services Slider']= '';
        $_w['Collapse Menu']= '';
        $_w['Courses'] = '';
        $_w['Questions Management'] = '';
        $_w['Questions'] = '';
        $_w['Paper Management'] = '';
        $_w['Generate Paper'] = '';
        $_w['Assign Papers'] = '';
        //Main Menu List End

        //SubMenu List
        $_w['Briefing File'] = '';
        $_w['Product View'] = '';
        $_w['Product Sort'] = '';
        $_w['Add New Product'] = '';
        $_w['Product Discount'] = '';
        $_w['Product Whole Sale'] = '';
        $_w['Product Coupon'] = '';
        $_w['Manage Currency'] = '';
        $_w['Manage Scales'] = '';
        $_w['Manage Color'] = '';
        $_w['Manage Category'] = '';
        $_w['View Stock Product'] = '';
        $_w['Purchase Receipt'] = '';
        $_w['Store Location'] = '';
        $_w['Import/Export'] = '';
        $_w['Orders'] = '';
        $_w['Invoice List'] = '';
        $_w['Shipping By Weight'] = '';
        $_w['Shipping By Class'] = '';
        $_w['Main Menu'] = '';
        $_w['Footer Menu'] = '';
        $_w['Defect Archive'] = '';
        $_w['Defect Register'] = '';
        $_w['Return Archive'] = '';
        $_w['Product Return Form'] = '';
        $_w['Product Defect Form'] = '';
        $_w['Pages'] = '';
        $_w['New Page'] = '';
        $_w['Home Page'] = '';

        $_w['News & Events'] = '';
        $_w['News'] = '';
        $_w['Add News'] = '';

        $_w['Webinar'] = '';
        $_w['Webinars'] = '';
        $_w['Add Webinar'] = '';

        // $_w['Reviews']= '';
        $_w['Banners'] = '';
        $_w['Icons'] = '';
        $_w['Brands'] = '';
        $_w['Media'] = '';
        $_w['Gallery'] = '';
        $_w['Images'] = '';
        $_w['Files'] = '';
        $_w['SEO'] = '';
        $_w['IBMS Setting'] = '';
        $_w['History'] = '';
        $_w['Account'] = '';
        $_w['Translate Language'] = '';
        $_w['Subscribe Emails'] = '';
        $_w['News Letter'] = '';
        $_w['Products List'] = '';
        $_w['Emails Content'] = '';
        $_w['Users'] = '';
        $_w['Admin Users'] = '';
        $_w['Admin Group'] = '';
        $_w['Web Users'] = '';
        $_w['Blog'] = '';
        $_w['Collapse Menu'] = '';
        $_w['Reviews'] = '';
        $_w['Questions'] = '';
        $_w['File Manager'] = '';
        $_w['Testimonial'] = '';
        $_w['Measurement'] = '';
        $_w['Deal Product'] = '';
        $_w['Gift Card Management'] = '';
        $_w['Gift Card'] = '';
        $_w['Products and Recipes'] = '';
        $_w['Products'] = '';
        $_w['Recipes'] = '';
        $_w['Add Product'] = '';
        $_w['Service Slider'] = '';
        $_w['Media Room Slider'] = '';
        $_w['Financial Reports'] = '';
        $_w['Add Page Menu'] = '';
        $_w['Page Menu'] = '';
        $_w['Manage Categories'] = '';
        $_w['Booking Form'] = '';
        $_w['Form Data'] = '';
        // $_w['Users'] = '';
        $_w['Users & Ticket'] = '';
        $_w['Ticket'] = '';
        $_w['Ticket User Management'] = '';
        $_w['Subscribe Faq'] = '';
        $_w['FAQ'] = '';
        $_w['Blog']= '';
        $_w['Trash Data']= '';
        $_w['Terms And Condition']='';
        $_w['Add Terms']='';
        $_w['Safety Data'] = '';
        
        
        //SubMenu List End

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'AdminMenu');

        //Files Modification restriction here
        $md5PageStatus = $this->functions->checkCurrentFileMd5();
        if($md5PageStatus==false){
            $md5PageStatus = $this->functions->checkCurrentFileMd5(true);
            echo "Your Page is modified and cant Be show,
                        Please Undo your changing in files. If you want to modify any changes, please contact to Imedia. <br>";
            //find Actual File Where edit made
            exit;
        }
        //check developer Setting
        if(isset($_SESSION['admin']['setting'])){
            //making secure session
            if($_SESSION['admin']['setting']!='1' && isset($_SESSION['admin']['settingStatus'])){
                echo "Developer Setting table value is change, please Undo Your Changes to continue.";
                exit;
            }elseif($_SESSION['admin']['setting']=='0'){
                $_SESSION['admin']['setting']='1';
                $_SESSION['admin']['settingStatus'] = 'ok';
            }
        }else{
            $developerSetting = $this->functions->encryptDeveloperSetting();
            if($developerSetting){
                $_SESSION['admin']['setting'] = uniqid();
            }else{
                echo "Developer Setting table value is change, please Undo Your Changes to continue.";
                exit;
            }
        }
        //Files Modification restriction here End

    }

    public $AutoVisibleMenu;
    public $AutoVisibleMenuLink;
    public $AutoVisibleMenuName;
    public $parentMenu;

    public function autoVisibleMenuArray(){
        $this->menu();
        return $this->AutoVisibleMenu;
    }

    public function visibleForThisProject(){
        //Not in use
        global $_e;
    }

    /*
     * menu
     * dropDown icon <span class="fa fa-chevron-down drop_menu"></span>
     * after dropDown ul <span class="fa fa-caret-left collapse_icon"></span>
     *
     * */
    public function menu()
    {
        global $_e;
        $this->AutoVisibleMenu = null;
        $this->AutoVisibleMenuLink = null;
        $this->AutoVisibleMenuName = null;
        return '

        <div id="IBMS_Menu" class="">
        <ul>
            <li class="' . $this->checkActive('Dashboard','Dashboard') . '">
                <a href="index.php"><h3><span class="fa fa-tachometer icon"></span> <span class="menu_h3">' . $_e['Dashboard'] .'</span></h3></a>
            </li>
            <li class="' . $this->checkActive('product_spb','Shop Products') . '">
                <h3><span class="fa fa-cube icon"></span><span class="menu_h3">Shop ' . $_e['Products'].'</span> <span class="fa fa-chevron-down drop_menu" style="font-size:12px;"></span> </h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('Product View','-product_spb?page=list') . '><a href="-product_spb?page=list">' . $_e['Product View'] .'</a></li>
                    <li ' . $this->checkSubMenu('New Product','-product_spb?page=add') . '><a href="-product_spb?page=add">' . $_e['Add New Product'] .'</a></li>
                    <li ' . $this->checkSubMenu('Deal Product','-productDeal?page=deal',false) . '><a href="-productDeal?page=deal">' . $_e['Deal Product'] .'</a></li>

                    <li></li>
                    <li class="text-center disabled">'.$_e['Setting'].'<a></a></li>
                    <li></li>

                    <li ' . $this->checkSubMenu('Product Sort','-product_spb?page=sort',false) . '><a href="-product_spb?page=sort">' . $_e['Product Sort'] .'</a></li>
                    <li ' . $this->checkSubMenu('Manage Currency','-product_management?page=currency',false) . '><a href="-product_management?page=currency">' . $_e['Manage Currency'] .'</a></li>
                    <li ' . $this->checkSubMenu('Manage Scales','-product_management?page=scale',false) . '><a href="-product_management?page=scale">' . $_e['Manage Scales'] .'</a></li>
                    <li ' . $this->checkSubMenu('Manage Color','-product_management?page=color',false) . '><a href="-product_management?page=color">' . $_e['Manage Color'] .'</a></li>
                    <li ' . $this->checkSubMenu('Manage Category','-product_management?page=category',false) . '><a href="-product_management?page=category">' . $_e['Manage Category'] .'</a></li>
                    <li ' . $this->checkSubMenu('Product Discount','-product_spb?page=pDiscount',false).'><a href="-product_spb?page=pDiscount">' . $_e['Product Discount'] .'</a></li>
                    <li ' . $this->checkSubMenu('Product Sale','-product_spb?page=pSale',false) . '><a href="-product_spb?page=pSale">' . $_e['Product Whole Sale'] .'</a></li>
                    <li ' . $this->checkSubMenu('Product Coupon','-product_spb?page=pCoupon',true) . '><a href="-product_spb?page=pCoupon">' . $_e['Product Coupon'] .'</a></li>
                    <li ' . $this->checkSubMenu('Measurement','-measurement?page=measurement',false) . '><a href="-measurement?page=measurement">' . $_e['Measurement'] .'</a></li>
                </ul>
            </li>


           <li class="' . $this->checkActive('stock','Stock Management', false) . '">
                <h3><span class="fa fa-cubes icon"></span><span class="menu_h3">' . $_e['Stock Management'] .'</span>
                    <span class="fa fa-chevron-down drop_menu"></span>
                </h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('inventory','-stock?page=inventory') . '><a href="-stock?page=inventory">' . $_e['View Stock Product'] .'</a></li>
                    <li ' . $this->checkSubMenu('purchase receipt','-stock?page=purchaseReceipt') . '><a href="-stock?page=purchaseReceipt">' . $_e['Purchase Receipt'] .'</a></li>
                    <li ' . $this->checkSubMenu('add store','-stock?page=addStore') . '><a href="-stock?page=addStore">' . $_e['Store Location'] .'</a></li>
                    <li ' . $this->checkSubMenu('Import/Export','-stock?page=csv') . '><a href="-stock?page=csv">' . $_e['Import/Export'] .'</a></li>
                </ul>
            </li>



            <li class="' . $this->checkActive('orderManagements','Order Management') . '">
                <h3><span class="fa fa-shopping-cart icon"></span><span class="menu_h3">' . $_e['Order Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('newOrder','-order_spb?page=newOrder') . '><a href="-order_spb?page=newOrder">' . $_e['Orders'] .'</a></li> 

                    <li ' . $this->checkSubMenu('invoicelist','-order_spb?page=invoicelist') . '><a href="-order_spb?page=invoicelist">' . $_e['Invoice List'] .'</a></li>


                    <li ' . $this->checkSubMenu('reports',"-order_spb?page=reports") . '><a href="-order_spb?page=reports">View Reports</a></li>




                </ul>
            </li>





















              <li class="' . $this->checkActive('product','Stock Products') . '">

                <h3><span class="fa fa-cube icon"></span><span class="menu_h3">Stock ' . $_e['Products'].'</span> <span class="fa fa-chevron-down drop_menu"></span> </h3>

                <ul>

                    <span class="fa fa-caret-left collapse_icon"></span>

                    <li ' . $this->checkSubMenu('Product View','-product?page=list') . '><a href="-product?page=list">' . $_e['Product View'] .'</a></li>

                    <li ' . $this->checkSubMenu('New Product','-product?page=add') . '><a href="-product?page=add">' . $_e['Add New Product'] .'</a></li>
                    
                             
                    <li ' . $this->checkSubMenu('Sort Products Image','-product?page=update',false) . '><a href="-product?page=update">' . $_e['Sort Products Image'] .'</a></li>
                    
                    
                    





                    <li></li>

                    <li class="text-center disabled">'.$_e['Setting'].'<a></a></li>

                    <li></li>



                    <li ' . $this->checkSubMenu('Product Sort','-product?page=sort',false) . '><a href="-product?page=sort">' . $_e['Product Sort'] .'</a></li>

       


                    <li ' . $this->checkSubMenu('Manage Scales','-product_management?page=scale') . '><a href="-product_management?page=scale">' . $_e['Manage Scales'] .'</a></li>

                    <li ' . $this->checkSubMenu('Manage Color','-product_management?page=color') . '><a href="-product_management?page=color">' . $_e['Manage Color'] .'</a></li>

                    

                    <li ' . $this->checkSubMenu('managecat',"-categories?page=managecat") . '><a href="-categories?page=managecat">' . $_e['Manage Categories'] .'</a></li>

                    <li ' . $this->checkSubMenu('Product Discount','-product?page=pDiscount',false).'><a href="-product?page=pDiscount">' . $_e['Product Discount'] .'</a></li>

                    <li ' . $this->checkSubMenu('Product Sale','-product?page=pSale',false) . '><a href="-product?page=pSale">' . $_e['Product Whole Sale'] .'</a></li>

                    <li ' . $this->checkSubMenu('Product Coupon','-product?page=pCoupon',false) . '><a href="-product?page=pCoupon">' . $_e['Product Coupon'] .'</a></li>

           



                  
                  
                  
                  
                    <li ' . $this->checkSubMenu('impExp','-productPortation?page=csv',false) . '><a href="-productPortation?page=csv">' . $_e['Import/Export'] .'</a></li>

                </ul>

            </li>



           <li class="' . $this->checkActive('stock','Stock Management') . '">

                <h3><span class="fa fa-cubes icon"></span><span class="menu_h3">' . $_e['Stock Management'] .'</span>

                    <span class="fa fa-chevron-down drop_menu"></span>

                </h3>

                <ul>

                    <span class="fa fa-caret-left collapse_icon"></span>

                    <li ' . $this->checkSubMenu('inventory','-stock?page=inventory') . '><a href="-stock?page=inventory">' . $_e['View Stock Product'] .'</a></li>

                    <li ' . $this->checkSubMenu('purchase receipt','-stock?page=purchaseReceipt') . '><a href="-stock?page=purchaseReceipt">' . $_e['Purchase Receipt'] .'</a></li>
                     <li ' . $this->checkSubMenu('goods transfer note','-stock?page=goodstransfernote',false) . '><a href="-stock?page=goodstransfernote">' . $_e['Goods Transfer Note'] .'</a></li>
                   
                    <li ' . $this->checkSubMenu('inventory adjustment note','-stock?page=inventoryadjustmentnote',false) . '><a href="-stock?page=inventoryadjustmentnote">'.$_e['Inventory Adjustment Note'].'</a></li>
                    <li ' . $this->checkSubMenu('inventory valuation','-stock?page=inventoryvaluation') . '><a href="-stock?page=inventoryvaluation">Inventory Valuation</a></li>
                    <li ' . $this->checkSubMenu('inventory in out','-stock?page=inventoryinout') . '><a href="-stock?page=inventoryinout">Inventory In Out</a></li>
                    <li ' . $this->checkSubMenu('add store','-stock?page=addStore',false) . '><a href="-stock?page=addStore">' . $_e['Store Location'] .'</a></li>

                    <li ' . $this->checkSubMenu('Import/Export','-stock?page=csv',false) . '><a href="-stock?page=csv">' . $_e['Import/Export'] .'</a></li>

                </ul>

            </li>



            <li class="' . $this->checkActive('orderManagement','Order Management',false) . '">

                <h3><span class="fa fa-shopping-cart icon"></span><span class="menu_h3">' . $_e['Order Management'] .'</span>

                 <span class="fa fa-chevron-down drop_menu"></span></h3>

                <ul>

                    <span class="fa fa-caret-left collapse_icon"></span>

                    <li ' . $this->checkSubMenu('newOrder','-order?page=newOrder') . '><a href="-order?page=newOrder">' . $_e['Orders'] .'</a></li>
                    
                    <li ' . $this->checkSubMenu('Import/Export','-order?page=csv') . '><a href="-order?page=csv">' . $_e['Import/Export'] .'</a></li>



               
               





                </ul>

            </li>


            <li class="' . $this->checkActive('statics','Statics', false) . '">
                <h3><span class="fa fa-bar-chart-o icon"></span><span class="menu_h3">' . $_e['Statics'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu ( 'statics' , "-statics?page=statics" ) . '><a href="-statics?page=statics">' . @$_e['Statics'] .'</a></li>
                </ul>
            </li>



<li class="' . $this->checkActive('cpdGeneraterM','CPD Generator',false) . '">
<h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">CPD Generator</span>
<span class="fa fa-chevron-down drop_menu"></span></h3>
<ul>
<span class="fa fa-caret-left collapse_icon"></span>

<li ' . $this->checkSubMenu('addCpdGenerater',"-cpdGenerater?page=addCpdGenerater") . '><a href="-cpdGenerater?page=addCpdGenerater">Fill Form</a></li>
</ul>
</li>

            <li class="' . $this->checkActive('domain','Domains') . '">
                <h3><span class="fa fa-book icon"></span><span class="menu_h3">' . $_e['Questions Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu ( 'domain' , "-domain?page=domain" ) . '><a href="-domain?page=domain">' . @$_e['Courses'] .'</a></li>
                    <li ' . $this->checkSubMenu ( 'questions' , "-question?page=question" ) . '><a href="-question?page=question">' . @$_e['Questions'] .'</a></li>
                </ul>
            </li>


            <li class="' . $this->checkActive('paper','Paper') . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['Paper Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu ( 'paper' , "-paper?page=paper" ) . '><a href="-paper?page=paper">' . @$_e['Generate Paper'] .'</a></li>
                    <li ' . $this->checkSubMenu ( 'assign' , "-paper?page=assign" ) . '><a href="-paper?page=assign">' . @$_e['Assign Papers'] .'</a></li>


                      <li ' . $this->checkSubMenu('addCpdGenerater',"-paper?page=addCpdGenerater") . '><a href="-paper?page=addCpdGenerater">Certificate generator</a></li>





                </ul>
            </li>


            <li class="' . $this->checkActive('shippingManagement','Shipping Management', false) . '">
                <h3><span class="fa fa-truck icon"></span><span class="menu_h3">' . $_e['Shipping Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('shipping by weight', "-shipping?page=shipping") . '><a href="-shipping?page=shipping">' . @$_e['Shipping By Weight'] .'</a></li>
                    <li ' . $this->checkSubMenu('shipping by class' , "-shipping?page=shippingByClass") . '><a href="-shipping?page=shippingByClass">' . @$_e['Shipping By Class'] .'</a></li>
                </ul>
            </li>

            <li class="' . $this->checkActive('webMenuM','Menu') . '">
                <h3><span class="fa fa-navicon icon"></span><span class="menu_h3">' . $_e['Menu'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('menu',"-menu?page=menu") . '><a href="-menu?page=menu">' . $_e['Main Menu'] .'</a></li>
                    <li ' . $this->checkSubMenu('footerMenu',"-menu?page=footerMenu", false) . '><a href="-menu?page=footerMenu">' . $_e['Footer Menu'] .'</a></li>
                </ul>
            </li>

            <li class="' . $this->checkActive('productsM','Products', false) . '">
                <h3><span class="fa fa-navicon icon"></span><span class="menu_h3">' . $_e['Products Boxes'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('recipe',"-recipes?page=view_add_recipe",false) . '><a href="-recipes?page=view_add_recipe">' . $_e['Recipes'] .'</a></li>
                    <li ' . $this->checkSubMenu('products',"-products?page=products") . '><a href="-products?page=products">' . $_e['Products'] .'</a></li>
                    <li ' . $this->checkSubMenu('addproducts',"-products?page=addproducts") . '><a href="-products?page=addproducts">' . $_e['Add Product'] .'</a></li>
                    <li ' . $this->checkSubMenu('managecat',"-categories?page=managecat", false) . '><a href="-categories?page=managecat">' . $_e['Manage Categories'] .'</a></li>
                </ul>
            </li>


            <li class="' . $this->checkActive('logs','Logs Management', false) . '">
                <h3><span class="fa fa-bug icon"></span><span class="menu_h3">' . $_e['Logs Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('defectArchive',"-logs?page=defectArchive") . '><a href="-logs?page=defectArchive">' . $_e['Defect Archive'] .'</a></li>
                    <li ' . $this->checkSubMenu('defectReg',"-logs?page=defectReg") . '><a href="-logs?page=defectReg">' . $_e['Defect Register'] .'</a></li>
                    <li ' . $this->checkSubMenu('returnReg',"-logs?page=returnReg") . '><a href="-logs?page=returnReg">' . $_e['Return Archive'] .'</a></li>
                    <li ' . $this->checkSubMenu('productReturn',"-logs?page=productReturn") . '><a href="-logs?page=productReturn">' . $_e['Product Return Form'] .'</a></li>
                    <li ' . $this->checkSubMenu('productDefect',"-logs?page=productDefect") . '><a href="-logs?page=productDefect">' . $_e['Product Defect Form'] .'</a></li>
                </ul>
            </li>

            <li class="' . $this->checkActive('pages','Pages') . '">
                <h3><span class="fa fa-file-text icon"></span><span class="menu_h3">' . $_e['Pages'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('page',"-pages?page=page") . '><a href="-pages?page=page">' . $_e['Pages'] .'</a></li>
                    <li ' . $this->checkSubMenu('pageNew',"-pages?page=pageNew") . '><a href="-pages?page=pageNew">' . $_e['New Page'] .'</a></li>
                    <li ' . $this->checkSubMenu('homePage',"-pages?page=homePage") . '><a href="-pages?page=homePage">' . $_e['Home Page'] .'</a></li>


<li ' . $this->checkSubMenu('newslider',"-newslider?page=newslider", false) . '><a href="-newslider?page=newslider">' . 'CQC Key Line' .'</a></li>

                    <li ' . $this->checkSubMenu('mediaRoom',"-mediaRoom?page=brands", false) . '><a href="-mediaRoom?page=brands">' . $_e['Media Room Slider'] .'</a></li>
                    <li ' . $this->checkSubMenu('financial_reports',"-financial_reports?page=reports", false) . '><a href="-financial_reports?page=reports">' . $_e['Financial Reports'] .'</a></li>

<li ' . $this->checkSubMenu('file',"-file?page=reports", false) . '>

<a href="-file?page=reports">' . $_e['Briefing File'] .'</a></li>


                    <li ' . $this->checkSubMenu('newslider',"-newslider?page=newslider",false) . '><a href="-newslider?page=newslider">' . $_e['Services Slider'] .'</a></li>









        <li ' . $this->checkSubMenu('financial_reports',"-financial_reports?page=reports",false) . '><a href="-financial_reports?page=reports">' . 'Financial reports' .'</a></li>




  





                          <li ' . $this->checkSubMenu('brands',"-brands?page=brands", false) . '><a href="-brands?page=brands">' . 'Brands Management' .'</a></li>

  <li ' . $this->checkSubMenu('client',"-client?page=client") . '><a href="-client?page=client">' . 'Courses' .'</a></li>

  <li ' . $this->checkSubMenu('tabs',"-tabs?page=tabs") . '><a href="-tabs?page=tabs">
Packages
  </a></li>

                          
                    <li ' . $this->checkSubMenu('fileManager',"-fileManager?page=fileManager",true) . '><a href="-fileManager?page=fileManager">' . $_e['File Manager'] .'</a></li>
                    <li ' . $this->checkSubMenu('safetyData',"-safetyData?page=safetyData",true) . '><a href="-safetyData?page=safetyData">' . $_e['Safety Data'] .'</a></li>
                    <li ' . $this->checkSubMenu('testimonial',"-testimonial?page=testimonial",true) . '><a href="-testimonial?page=testimonial">' . $_e['Testimonial'] .'</a></li>
                 </ul>
            </li>

            <li class="' . $this->checkActive('page_menuM','page_menu',false) . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['Page Menu'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('page_menu',"-page_menu?page=page_menu") . '><a href="-page_menu?page=page_menu">' . $_e['Page Menu'] .'</a></li>
                  
                    <li ' . $this->checkSubMenu('addpage_menu',"-page_menu?page=addpage_menu") . '><a href="-page_menu?page=addpage_menu">' . $_e['Add Page Menu'] .'</a></li>
                </ul>
            </li>

               <li class="' . $this->checkActive('fm_newsM','fm_news',false) . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">Career Position</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('fm_news',"-fm_news?page=fm_news") . '><a href="-fm_news?page=fm_news">View</a></li>
                  
<li ' . $this->checkSubMenu('addfm_news',"-fm_news?page=addfm_news",false) . '><a href="-fm_news?page=addfm_news">Add</a></li>
                </ul>
            </li>




  <li class="' . $this->checkActive('myUploadsM','My Uploads') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'My Uploads' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('myUploads',"-myUploads?page=myUploads") . '><a href="-myUploads?page=myUploads">' . 'View' .'</a></li>
                </ul>
            </li>

  <li class="' . $this->checkActive('serviceM','Training Academy',false) . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'Training Academy' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('service',"-service?page=service") . '><a href="-service?page=service">' . 'Add / Edit' .'</a></li>
                </ul>
            </li>


 <li class="' . $this->checkActive('eventManagement','Event Management') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'Event Management' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('eventManagement',"-eventManagement?page=eventManagement") . '><a href="-eventManagement?page=eventManagement">' . 'Event' .'</a></li>

                <li ' . $this->checkSubMenu('addeventManagement',"-eventManagement?page=addeventManagement") . '><a href="-eventManagement?page=addeventManagement">' . 'Add Event' .'</a></li>
                                                      
                    <li ' . $this->checkSubMenu('userevent',"-userEvent?page=userevent") . '><a href="-userEvent?page=userevent">' . 'User Event' .'</a></li>
                  
                    <li ' . $this->checkSubMenu('eventForm',"-eventForm?page=eventForm") . '><a href="-eventForm?page=eventForm">' . 'Event Forms' .'</a></li>
               
                <li ' . $this->checkSubMenu('addeventForm',"-eventForm?page=addeventForm") . '><a href="-eventForm?page=addeventForm">' . 'Add Event Forms' .'</a></li>
                   
                    <li ' . $this->checkSubMenu('usereventForm',"-usereventForm?page=eventForm") . '><a href="-usereventForm?page=usereventForm">' . 'User Event Forms' .'</a></li>
                </ul>
            </li>

             <li class="' . $this->checkActive('documents','Staff Documents') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'Staff Folders' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('documents',"-documents?page=documents") . '><a href="-documents?page=documents">' . 'Add Documents' .'</a></li>
                    <li ' . $this->checkSubMenu('userdocuments',"-userdocuments?page=userdocuments") . '><a href="-userdocuments?page=userdocuments">' . 'User Documents' .'</a></li>
                </ul>
            </li>

            <li class="' . $this->checkActive('freeResourcesM','Free Resourses') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'Free Resourses' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('freeResources',"-free_resources?page=documents") . '><a href="-free_resources?page=documents">' . 'Add Documents' .'</a></li>
                    
                </ul>
            </li>

  <li class="' . $this->checkActive('messagesM','BOD Management',false) . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'BOD Management' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('messages',"-messages?page=testimonial") . '><a href="-messages?page=messages">' . 'Add' .'</a></li>
                </ul>
            </li>












            <li class="' . $this->checkActive('postM','POST') . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['POST'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('post',"-post?page=post") . '><a href="-post?page=post">' . $_e['Post'] .'</a></li>
                  <!---  <li ' . $this->checkSubMenu('addpost',"-post?page=addpost") . '><a href="-post?page=addpost">' . $_e['Add Post'] .'</a></li>---->
                </ul>
            </li>

            <li class="' . $this->checkActive('newsM','News & Events') . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['News & Events'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('news',"-news?page=news") . '><a href="-news?page=news">' . $_e['News'] .'</a></li>
                    <li ' . $this->checkSubMenu('addNews',"-news?page=addNews") . '><a href="-news?page=addNews">' . $_e['Add News'] .'</a></li>
                </ul>
            </li>






<li class="' . $this->checkActive('issuesM','User Report Issues') . '">
<h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">User Report Issues</span>
<span class="fa fa-chevron-down drop_menu"></span></h3>
<ul>
<span class="fa fa-caret-left collapse_icon"></span>
<li ' . $this->checkSubMenu('issues',"-issues?page=issue") . '><a href="-issues?page=issue">View</a></li>


</ul>
</li>

            <li class="' . $this->checkActive('webinarM','Webinar',true) . '">

                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['Webinar'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('webinar',"-webinar?page=webinar") . '><a href="-webinar?page=webinar">' . $_e['Webinars'] .'</a></li>

                    <li ' . $this->checkSubMenu('addWebinar',"-webinar?page=addWebinar") . '><a href="-webinar?page=addWebinar">' . $_e['Add Webinar'] .'</a></li>
                </ul>
            </li>


            <li class="' . $this->checkActive('bookingFormM','Booking Form') . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['Booking Form'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('bookingForm',"-bookForm?page=bookingForm") . '><a href="-bookingForm?page=bookingForm">' . 'Add Service' .'</a></li>
                    <li ' . $this->checkSubMenu('emailTXT',"-email?page=emailMsg") . '><a href="-email?page=emailTXT">Form Data</a></li>
                    <li ' . $this->checkSubMenu('lunchandlearn',"-bookForm?page=lunchandlearn") . '><a href="-bookingForm?page=lunchandlearn">' . 'Lunch And Learn Booking' .'</a></li>
                    <li ' . $this->checkSubMenu('inhouseFormM',"-inhouseForm?page=formData", true) . '><a href="-inhouseForm?page=formData">' . 'Inhouse Form' .'</a></li>
                </ul>
            </li>
            
            <li class="' . $this->checkActive('surveyFormM','Survey Form') . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . $_e['Form Data'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('formM',"-surveyForm?page=surveyForm") . '><a href="-surveyForm?page=surveyForm">' . 'All Forms' .'</a></li>
                </ul>
            </li>
            
            
            
            
            

 <li class="' . $this->checkActive('tabsnewM','Business Ethics Tabs',false) . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . 'Business Ethics Tabs' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('tabsnew',"-tabsnew?page=tabsnew") . '><a href="-tabsnew?page=tabsnew">' . 'View' .'</a></li>
                    <li ' . $this->checkSubMenu('addTabs',"-tabsnew?page=addTabs") . '><a href="-tabsnew?page=addTabs">' . 'Add New' .'</a></li>
                </ul>
            </li>









<li class="' . $this->checkActive('careersM','Careers Management',false) . '">
<h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . 'Careers Management' .'</span>
<span class="fa fa-chevron-down drop_menu"></span></h3>
<ul>
<span class="fa fa-caret-left collapse_icon"></span>
<li ' . $this->checkSubMenu('careers',"-careers?page=careers") . '><a href="-careers?page=careers">' . 'View' .'</a></li>
<li ' . $this->checkSubMenu('addCareers',"-careers?page=addCareers") . '><a href="-careers?page=addCareers">Add </a></li>
</ul>
</li>


            <li class="' . $this->checkActive('rotaM','Rota Management', true) . '">
                <h3><span class="fa fa-navicon icon"></span><span class="menu_h3">Rota Management</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('rota',"-rota?page=rota",true) . '><a href="-rota?page=rota">Rota</a></li>
                    <li ' . $this->checkSubMenu('shift',"-rota?page=addshift",false) . '><a href="-rota?page=addshift">Shift</a></li>
                </ul>
            </li>


            <li class="' . $this->checkActive('bannersM','Banners') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . $_e['Banners'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('banners',"-banners?page=banners") . '><a href="-banners?page=banners">' . $_e['Banners'] .'</a></li>
                </ul>
                
            </li>
            
            <li class="' . $this->checkActive('reviewsM','Reviews') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . $_e['Reviews'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('reviews',"-review?page=review") . '><a href="-review?page=review">' . $_e['Reviews'] .'</a></li>
                </ul>
                
            </li>

            <li class="' . $this->checkActive('galleryM','Media', true) . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . $_e['Media'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                     <li ' . $this->checkSubMenu('gallery',"-gallery?page=gallery",true) . '><a href="-gallery?page=gallery">' . $_e['Gallery'] .'</a></li>
                     <li ' . $this->checkSubMenu('Images',"editor/kcfinder/browse.php?type=images") . '><a onclick="openWin(\'editor/kcfinder/browse.php?type=images\')">' . $_e['Images'] .'</a></li>
                     <li ' . $this->checkSubMenu('Files',"editor/kcfinder/browse.php?type=files") . '><a onclick="openWin(\'editor/kcfinder/browse.php?type=files\')">' . $_e['Files'] .'</a></li>
                </ul>
            </li>










<li class="' . $this->checkActive('videoM','video',false) . '">
<h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">' . 'Video Management' .'</span>
<span class="fa fa-chevron-down drop_menu"></span></h3>
<ul>
<span class="fa fa-caret-left collapse_icon"></span>
<li ' . $this->checkSubMenu('video',"-video?page=video") . '><a href="-video?page=video">' . 'View' .'</a></li>

<li ' . $this->checkSubMenu('addvideo',"-video?page=addvideo") . '><a href="-video?page=addvideo">' . 'Add' .'</a></li>
</ul>
</li>










            <li class="' . $this->checkActive('seoM','SEO Management') . '">
                <h3><span class="fa fa-globe icon"></span><span class="menu_h3">' . $_e['SEO Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('seo',"-seo?page=seo") . '><a href="-seo?page=seo">' . $_e['SEO'] .'</a></li>
                </ul>
            </li>

             <li class="' . $this->checkActive('giftCardM','Gift Card Management', false) . '">
                <h3><span class="fa fa-gift icon"></span><span class="menu_h3">' . $_e['Gift Card Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('giftCard',"-giftcard?page=giftCard") . '><a href="-giftcard?page=giftCard">' . $_e['Gift Card'] .'</a></li>
                </ul>
            </li>

           <li class="' . $this->checkActive('adminSetting','Setting') . '">
                <h3><span class="fa fa-gears icon"></span><span class="menu_h3">' . $_e['Setting'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('IBMSSetting','-setting?page=IBMSSetting') . '><a href="-setting?page=IBMSSetting">' . $_e['IBMS Setting'] .'</a></li>
                    <li ' . $this->checkSubMenu('history',"-setting?page=history") . '><a href="-setting?page=history">' . $_e['History'] .'</a></li>
                    <li ' . $this->checkSubMenu('account',"-setting?page=account") . '><a href="-setting?page=account">' . $_e['Account'] .'</a></li>
                    <li ' . $this->checkSubMenu('hardWords',"-setting?page=hardWords",false) . '><a href="-setting?page=hardWords">' . $_e['Translate Language'] .'</a></li>
                   
                    <li ' . $this->checkSubMenu('Trash',"-setting?page=trash",true) . '><a href="-setting?page=trash">' . $_e['Trash Data'] .'</a></li>
                    <li ' . $this->checkSubMenu('Icons',"-setting?page=icons") . '><a href="-setting?page=icons">' . $_e['Icons'] .'</a></li>

                   
                    
                
                </ul>

            </li>

            <li class="' . $this->checkActive('emailM','Subscribe Email') . '">
                <h3><span class="fa fa-envelope icon"></span><span class="menu_h3">' . $_e['Email Management'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    
                     <li ' . $this->checkSubMenu('email',"-email?page=email") . '><a href="-email?page=email">' . $_e['Subscribe Emails'] .'</a></li>

                    <li ' . $this->checkSubMenu('emailContent',"-email?page=emailMsg") . '><a href="-email?page=emailContent">' . $_e['Emails Content'] .'</a></li>



                </ul>
            </li>
                
                <li class="' . $this->checkActive('faqM','FAQ') . '">
                <h3><span class="fa fa-image icon"></span><span class="menu_h3">' . 'FAQ' .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
             <li ' . $this->checkSubMenu('faq',"-faq?page=faq") . '><a href="-faq?page=faq">' . 'FAQ Add' .'</a></li>
         <!--- <li ' . $this->checkSubMenu('faq',"-faq?page=edit") . '><a href="-faq?page=edit">' . 'FAQ View' .'</a></li>--->
                </ul>
            </li>

           <li class="' . $this->checkActive('webUserM','Users') . '">
                <h3><span class="fa fa-users icon"></span><span class="menu_h3">' . $_e['Users'] .'</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('AdminUsers',"-webUsers?page=AdminUsers") . '><a href="-webUsers?page=AdminUsers">' . $_e['Admin Users'] .'</a></li>
                    <li ' . $this->checkSubMenu('AdminGrp',"-webUsers?page=AdminGrp") . '><a href="-webUsers?page=AdminGrp">' . $_e['Admin Group'] .'</a></li>
                    <li ' . $this->checkSubMenu('webUser',"-webUsers?page=view") . '><a href="-webUsers?page=view">' . $_e['Web Users'] .'</a></li>
                    <li ' . $this->checkSubMenu('reviews',"-webUsers?page=reviews",false) . '><a href="-webUsers?page=reviews">' . $_e['Reviews'] .'</a></li>
                    <li ' . $this->checkSubMenu('questions',"-webUsers?page=questions",false) . '><a href="-webUsers?page=questions">' . $_e['Questions'] .'</a></li>
                </ul>
            </li>




          <li class="' . $this->checkActive('reportsM','Report Of Users',false) . '">
                <h3><span class="fa fa-clipboard icon"></span><span class="menu_h3">Report Of Users</span>
                 <span class="fa fa-chevron-down drop_menu"></span></h3>
                <ul>
                    <span class="fa fa-caret-left collapse_icon"></span>
                    <li ' . $this->checkSubMenu('reports',"-reports?page=reports") . '><a href="-reports?page=reports">View All</a></li>
                   
                </ul>
            </li>
            
            <li class="' . $this->checkActive('termsM','Terms',false) . '">

                <h3><span class="fa fa-rss icon"></span><span class="menu_h3">' . $_e['Terms And Condition'] .'</span>

                 <span class="fa fa-chevron-down drop_menu"></span></h3>

                <ul>

                    <span class="fa fa-caret-left collapse_icon"></span>

                    <li ' . $this->checkSubMenu('terms',"-termsCondition?page=terms") . '><a href="-termsCondition?page=terms">' . $_e['Add Terms'] .'</a></li>

                </ul>
            </li>


            <li class="' . $this->checkActive('blogM','Blog',true) . '">

                <h3><span class="fa fa-rss icon"></span><span class="menu_h3">' . $_e['Blog'] .'</span>

                 <span class="fa fa-chevron-down drop_menu"></span></h3>

                <ul>

                    <span class="fa fa-caret-left collapse_icon"></span>

                    <li ' . $this->checkSubMenu('blog',"-blog?page=blog") . '><a href="-blog?page=blog">' . $_e['Blog'] .'</a></li>

                </ul>
            </li>

         

            <li id="collapse_menu">
                <h3>
                    <span class="fa fa-chevron-circle-left icon left"></span>
                    <span class="fa fa-chevron-circle-right icon right"></span>
                    <span class="menu_h3">' . $_e['Collapse Menu'] .'</span>
                </h3>
            </li>

        </ul>
    </div><!-- #IBMS_Menu -->

<script>
    /*jQuery time*/

    function openWin(url){
	myWindow=window.open(url,"","width=800,height=600");
	myWindow.focus();
}
    $(document).ready(function(){
        $("#IBMS_Menu h3").click(function(){
            //slide up all the link lists
            $("#IBMS_Menu ul ul").slideUp();
            //slide down the link list below the h3 clicked - only if its closed
            if(!$(this).next().is(":visible"))
            {
                $(this).next().slideDown();
            }
        });

         $("#collapse_menu").click(function(){
          $( ".IBMS_Main_Menu,#container_div" ).stop();
              if($(".IBMS_Main_Menu").hasClass("collapse_menu")){
                $( ".IBMS_Main_Menu,#container_div" ).removeAttr("style");
                $(".IBMS_Main_Menu").removeClass("collapse_menu");
                $("#container_div").removeClass("collapse_menu_active");
                $(".IBMS_Main_Menu").find("li.active").find("ul").slideDown(500);
                $.cookie("showTop", "null");

              }else{
                  $( ".IBMS_Main_Menu").animate({ width: "36"}, 500 );
                  $( "#container_div" ).animate({ width: "94%"}, 500 );
                $(".IBMS_Main_Menu").find("li.active").find("ul").hide(100);
                $(".IBMS_Main_Menu").addClass("collapse_menu");
                $("#container_div").addClass("collapse_menu_active");
                $.cookie("showTop", "collapse_menu");
              }
         });

         if($.cookie("showTop") == "collapse_menu"){
                $(".IBMS_Main_Menu").find("li.active").find("ul").hide();
                $(".IBMS_Main_Menu").addClass("collapse_menu");
                $("#container_div").addClass("collapse_menu_active");
         }
    });

</script>
';

    }

    private function checkActive($page,$name,$visibleForThisUser=true)
    {
        global $functions;

        $temp = '';

        if($visibleForThisUser===true){
            $this->parentMenu = $page;
            $this->AutoVisibleMenu['menu'][]   =   $page;
            $this->AutoVisibleMenu['hasSubMenu'][$page] =   false;
            $this->AutoVisibleMenuName[$page]  =   $name;
            $class  = "";

            $menuReturnPer  = $functions->adminMenuPermissions($page,'mainMenu');
            if($menuReturnPer===false){
                $class  = "displaynone";
            }
        }else{
            $this->parentMenu = false;
            $class  = "displaynone";
        }


        global $menu;
        if ($menu == $page) {
            $temp = "active";
        }

        return $temp." ".$class;
    }

    private function checkSubMenu($page,$link,$visibleForThisUser=true)
    {
        //$page is use as sub menu for active or permissions
        $temp = '';
        $class  = "";
        global $functions;
        $parentMenu = $this->parentMenu;

        if($parentMenu !== false) {
            $this->AutoVisibleMenu['hasSubMenu'][$parentMenu] =   true;
            // when this function call, its mean it has sub menu, menu is true or false, it  is else thing

            if ($visibleForThisUser === true) {
                //For take auto array and use where i want
                $this->AutoVisibleMenu[$parentMenu][$page] = $page;
                $this->AutoVisibleMenuLink[$page] = $link;
                $class = "";

                $menuReturnPer = $functions->adminMenuPermissions($link, 'subMenu', $parentMenu);
                //var_dump($menuReturnPer);
                if ($menuReturnPer === false) {
                    $class = "displaynone";
                }
            } else {
                $class = "displaynone";
            }
        }else{
            $class = "displaynone";
        }

        global $subMenu;
        if ($subMenu == $page) {
            $temp   = "class='subMenu $class'";
        }else{
            $temp   = "class='$class'";
        }

        return $temp;
    }
}

?>