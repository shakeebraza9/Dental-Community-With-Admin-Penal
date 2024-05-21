<?php







if(isset($_GET['page'])){



    require_once(__DIR__."/classes/ajax.php");



    $page=$_GET['page'];







    $ajax=new ajax();







    switch($page){



        //Color



        case 'colorAjax_edit':



            $ajax->processEdit('color');



            break;





        //GTN
        case 'receiptAjax_del_gtn':
            $ajax->AjaxDelScript_receiptDel_gtn();
            break;
        case 'receiptAjax_del_gtn_reverse':
            $ajax->AjaxDelScript_receiptDel_gtn_reverse();
            break;
        case 'receiptAjax_update_gtn_d':
            $ajax->AjaxUpdateScript_receiptUpdate_gtn_d();
            break; 
                
        case 'receiptAjax_update_gtn':
            $ajax->AjaxUpdateScript_receiptUpdate_gtn();
            break;     

        //DN
        case 'receiptAjax_del_dn':
            $ajax->AjaxDelScript_receiptDel_dn();
            break;

        case 'receiptAjax_del_dn_reverse':
            $ajax->AjaxDelScript_receiptDel_dn_reverse();
            break;

        case 'receiptAjax_update_dn_d':
            $ajax->AjaxUpdateScript_receiptUpdate_dn_d();
            break; 

        case 'receiptAjax_update_dn':
            $ajax->AjaxUpdateScript_receiptUpdate_dn();
            break; 
        //IAN
        case 'receiptAjax_del_ian':
            $ajax->AjaxDelScript_receiptDel_ian();
            break;

        case 'receiptAjax_update_ian_d':
            $ajax->AjaxUpdateScript_receiptUpdate_ian_d();
            break;  

        case 'receiptAjax_update_ian':
            $ajax->AjaxUpdateScript_receiptUpdate_ian();
            break; 

            case 'receiptAjax_update':
            $ajax->AjaxUpdateScript_receiptUpdate();
            break;
              case 'inventoryduplicateAjax_update':
            $ajax->AjaxUpdateScript_inventoryDuplicateUpdate();
            break;    
            
        case 'docEditDel':
            $ajax->docEditDel();
            break;    


        case 'AjaxUpdate_color':



            $ajax->AjaxUpdate_color();



            break;







        case 'colorAjax_del':



            $ajax->AjaxDelScript_color();



            break;







        case 'AjaxAfterUpdateScript_color':



            $ajax->AjaxAfterUpdateScript_color();



            break;







        // scale



        case 'scaleAjax_edit':



            $ajax->processEdit('scale');



            break;



        case 'AjaxUpdate_scale':



            $ajax->AjaxUpdate_scale();



            break;



        case 'AjaxAfterUpdateScript_scale':



            $ajax->AjaxAfterUpdateScript_scale();



            break;



        case 'scaleAjax_del':



            $ajax->AjaxDelScript_scale();



            break;







        //currency



        case 'AjaxUpdate_currency':



            $ajax->AjaxUpdate_currency();



            break;



        case 'AjaxAfterUpdateScript_currency':



            $ajax->AjaxAfterUpdateScript_currency();



            break;



        case 'currencyAjax_del':



            $ajax->AjaxDelScript_currency();



            break;







        // From product View list



        case 'singleProductDel':



            $ajax->AjaxDelScript_product();



            break;







        case 'selectedProductDel':



            $ajax->AjaxDelScript_productSelected();



            break;







        case 'productEditImageDel':



            $ajax->AjaxDelScript_productImageDel();



            break;







        //stock







        //store



        case 'storeAjax_del':



            $ajax->AjaxDelScript_storeDel();



            break;



        case 'storeEdit':



            $ajax->AjaxEditStore();



            break;







        case 'storeEditRequest':



            $ajax->AjaxEditRequestStore();



            break;



        case 'AjaxAfterUpdateScript_store':



            $ajax->AjaxAfterUpdateScript_store();



            break;



        //receipt



        case 'receiptAjax_del':



            $ajax->AjaxDelScript_receiptDel();



            break;







        //Discount



        case 'discountProductDel':



            $ajax->AjaxDelScript_discountDel();



            break;



        //Hole Sale



        case 'holeSaleDel':



            $ajax->AjaxDelScript_holeSaleDel();



            break;



        //Coupon



        case 'couponDel':



            $ajax->AjaxDelScript_couponDel();



            break;







       //Image Sort



        case 'sortProductImage':



            $ajax->sortProductImage();



            break;



        //Size Sort

        case 'sortProductSize':

            $ajax->sortProductSize();

            break;





       //Image Alt



        case 'pImageAltUpdate':



            $ajax->pImageAltUpdate();



            break;







        //Sort Products



        case 'sortProducts':



            $ajax->sortProducts();



        break;







        //featureItem



        case 'featureItem':



            $ajax->featureItem();



            break;



        case 'addProToCat':

            $ajax->addProToCat();

            break;



        case 'removeProFromCat':

            $ajax->removeProFromCat();

            break;

        case 'copyMissingProducts':

            $ajax->copyMissingProducts();
            
            break;


    }











}







?>