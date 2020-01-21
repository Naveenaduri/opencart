<?php
    include "../includes/connect.php";
    if(isset($_SESSION['farmer_num'])){

        if(isset($_POST['product_add'])){
            
            $pro_id= $_POST['pro_id'];
            $pro_quantity= $_POST['pro_quantity'];
            $pro_price= $_POST['pro_price'];
            
            
            $model = "SELECT * from oc_pro where pro_id=$pro_id";
            $model = mysqli_query($conn, $model);
            $model = mysqli_fetch_assoc($model);
            
            $add_pro = "INSERT INTO `oc_product`(`model`,phnum,pro_id, qnt,`sku`, `upc`, `ean`, `jan`, `isbn`, `mpn`, `location`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `points`, `tax_class_id`, `date_available`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `subtract`, `minimum`, `sort_order`, `status`, `viewed`, date_added,date_modified	) VALUES ('" . $model['pro_name'] . "','".$_SESSION['farmer_num']."',$pro_id , $pro_quantity,'', '', '', '', '', '', '', 1, 7, '" . $model['pro_img'] . "', 0, 1, '$pro_price', 0, 0, '" . date("Y-m-d") . "', 0, 1, 0, 0, 0, 1, 1, 1, 1, 1,1,'2009-02-03 16:06:50','2009-02-03 16:06:50')";
            $add_pro = mysqli_query($conn, $add_pro);
            $in_id = mysqli_insert_id($conn);
        
            $add_disc = "INSERT INTO `oc_product_description`(`product_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ($in_id,1,'" . $model['pro_name'] . "($pro_quantity" . "Kg)" . "','','','" . $model['pro_name'] . "','','')";
            $a1=mysqli_query($conn, $add_disc);
        
            $add_cat = "INSERT INTO oc_product_to_category(product_id,category_id) values($in_id,'" . $model['pro_category'] . "')";
            $a2=mysqli_query($conn, $add_cat);
        
            $add_layout = "INSERT INTO `oc_product_to_layout`(`product_id`, `store_id`, `layout_id`) VALUES ($in_id,0,0)";
            $a3=mysqli_query($conn, $add_layout);
        
            $add_store = "INSERT INTO `oc_product_to_store`(`product_id`, `store_id`) VALUES ($in_id,0)";
            $a4=mysqli_query($conn, $add_store);
            if($a1 && $a2 && $a3 && $a4 ){
                echo "Product Added Successfully.";
            }
        }

        if(isset($_POST['product_upd'])){
            
            $product_id= $_POST['product_id'];
            $pro_quantity= $_POST['pro_quantity'];
            $pro_price= $_POST['pro_price'];
            
            $pro_details = "SELECT pro_id from oc_product where product_id=$product_id";
            $pro_details = mysqli_query($conn,$pro_details);
            $pro_details = mysqli_fetch_assoc($pro_details);

            $pro_name="SELECT pro_name from oc_pro where pro_id = {$pro_details['pro_id']}";
            $pro_name=mysqli_query($conn,$pro_name);
            $pro_name=mysqli_fetch_assoc($pro_name);
            
            $add_pro = "UPDATE `oc_product` set price=$pro_price, qnt=$pro_quantity where product_id = $product_id";
            $add_pro = mysqli_query($conn, $add_pro);
            
        
            $add_disc = "UPDATE `oc_product_description` set name='".$pro_name['pro_name']."($pro_quantity Kg)"."' where product_id=$product_id";
            $a1=mysqli_query($conn, $add_disc);
        
            if($a1){
                echo "Product Added Successfully.";
            }
        }

        if(isset($_POST['product_del'])){

            $product_id=$_POST['product_id'];

            $del_pro = "DELETE from oc_product where product_id=$product_id";
            $a1=mysqli_query($conn,$del_pro);

            $del_disc = "DELETE from oc_product_description where product_id = $product_id";
            $a2=mysqli_query($conn,$del_disc);

            $del_cat = "DELETE from oc_product_to_category where product_id = $product_id";
            $a3=mysqli_query($conn, $del_cat);
            
            $del_layout = "DELETE from oc_product_to_layout where product_id = $product_id";
            $a4=mysqli_query($conn,$del_layout);

            $del_store = "DELETE from oc_product_to_store where product_id=$product_id";
            $a5=mysqli_query($conn, $del_store);
            if($a1 && $a2 && $a3 && $a4 && $a5){
                echo "Deleted Successfully";
            }else{
                echo "Failed To Delete";
            }
        }

        if(isset($_POST['product_sold'])){
            $product_id = $_POST['product_id'];
            $query = "UPDATE oc_product set status=0,quantity=0 where product_id=$product_id";
            $res = mysqli_query($conn,$query);
            if($res){
                echo "Product Has been Sold";
            } else{
                echo "Error! Occured";
            }
        }
    }
?>