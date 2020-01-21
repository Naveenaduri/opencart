<html>
    <head>
	 <script src="../farmers/vendor/jquery/jquery.js"></script>

    </head>
    <body>
        <?php
        $conn=mysqli_connect("localhost","root","","opencart");
        $data = file_get_contents("https://control.textlocal.in/feeds/inbox/?id=1049281&inbox=10&hash=ba1475525039fbdb31c9dbd7a60a0e51a66332a7485b5527f959cb1f5b0479da");
        $x = new SimpleXmlElement($data);
        echo "<pre>".$x."</pre>";
        $i=0;
        foreach($x->channel->item as $entry) {
            $i++;
            if($i==10){
            break;
            }
            // echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
            echo $i.".)".$entry->description. " ,,,,,  ";
            $str= $entry->description;
            // $str=explode(" ",$str);
            $time=$entry->pubDate;
            $mob=$entry->title;
            $valid="Select * from oc_farmer where oc_f_num='$mob'";
            $v=mysqli_query($conn,$valid);
            $rowcountf=mysqli_num_rows($v);
            $a = explode(' ', $str);
            
            if($rowcountf==1)
            {  
                $query="select * from oc_msg where mobile='$mob' and msgtime='$time'";
                // echo $query."<br>";
                $q=mysqli_query($conn,$query);
                $rowcount=mysqli_num_rows($q);
                // echo $rowcount."<br>";
                if($rowcount < 1)
                {
                    $query1="INSERT INTO `oc_msg`(`mobile`, `msg`, `msgtime`,`status`) VALUES ('$mob','$str','$time','1')";
                    // echo "$query1";
                    $q1=mysqli_query($conn,$query1);
                    if($q1){
                        echo "Not Found Inserted into Message Table". ",,,,,";
                    }
                    if($a[1] == "ADD")
                    {
                      if(count($a)==5)
                      {
                        $pro_id= $a[2];
                        $pro_quantity= $a[3];
                        $pro_price= $a[4];
                        
                        ?>
                        <script>
                            add_product(<?php echo $a[2].",".$a[3].",".$a[4] ?>);
                            function add_product(pro_id,pro_quantity,pro_price) 
                            {
                                    var pro_id = pro_id;
                                    var pro_quantity = pro_quantity;
                                    var pro_price = pro_price;

                                    var ret = true;
                                    
                                    $.ajax({
                                        url: '../farmers/queries/product.php',
                                        data: {
                                            pro_id: pro_id,
                                            pro_quantity: pro_quantity,
                                            pro_price: pro_price,
                                            product_add: ''
                                        },
                                        dataType: 'text',
                                        type: 'post',
                                        success: function(data) {
                                            console.log(data);
                                            // window.location = 'pro_view.php';
                                        },
                                        failure: function(data) {
                                            console.log('Error While Adding Product.');
                                        }
                                    });
                        }

                        </script>
                        <?php
                        $res=mysqli_insert_id($conn);
                        echo "Product Created Successfully". "<br>";
                        $message = "Product is Successfully added to the Website and Product id is:-"."$res";
                        include_once 'message.php';
                      } 
                      else
                      {
                        echo "Invalid Number of Fields". "<br>";
                        //   echo count($a);
                        $message = "Invalid Number of Fields";
                        include_once 'message.php';
                          
                      } 
                        
                    }
                    else if($a[1] == "DEL")
                    {
                        if(count($a)==3)
                        {
                            ?>
                            <script>
                            del(<?php echo $a[2]; ?>);
                            function del(id) 
                            {
                                
                                    $.ajax({
                                        url: '../farmers/queries/product.php',
                                        dataType: 'text',
                                        type: 'POST',
                                        data: {
                                            product_id: id,
                                            product_del: ''
                                        },
                                        success: function(data) {
                                            console.log(data);
                                        },
                                        failure: function(data) {
                                            console.log("Problem While Deleting.");
                                        }
                                    });
                                
                            }
                            </script>
                            <?php
                            echo "Product Deleted Successfully". "<br>";
                            $message = "Product is Successfully Deleted.";
                            include_once 'message.php';  
                        }
                        else
                        {
                            echo "Invalid Number of Fields". "<br>";
                            //   echo count($a);
                            $message = "Invalid Number of Fields";
                            include_once 'message.php';
                            
                        }  
                    }
                    else if($a[1]=="UPD")
                    {
                        if(count($a)==5)
                        {
                            ?>
                        <script>
                            upd(<?php echo $a[2].",".$a[3].",".$a[4] ?>);
                            function upd(pro_id,pro_quantity,pro_price) 
                            {
                                    var product_id = pro_id;
                                    var pro_quantity = pro_quantity;
                                    var pro_price = pro_price;

                                    var ret = true;
                                    
                                    $.ajax({
                                    url: '../farmers/queries/product.php',
                                    data: {
                                        product_id: product_id,
                                        pro_quantity: pro_quantity,
                                        pro_price: pro_price,
                                        product_upd: ''
                                    },
                                    dataType: 'text',
                                    type: 'post',
                                    success: function(data) {
                                        console.log(data);
                                        // window.location = 'pro_view.php';
                                    },
                                    failure: function(data) {
                                        console.log('Error While Adding Product.');
                                    }
                                });
                            }

                        </script>
                        <?php

                                echo "Product Updated Successfully.". "<br>";
                                $message = "Your Product  with Id". $a[2]." is Successfully Updated.";
                                include_once 'message.php';
                            

                        }
                        else{
                            echo "Invalid Number of Fields". "<br>";
                            $message = "Invalid Number of Fields";
                            include_once 'message.php';
                        }
                    }
                    else if($a[1]=="SOLD")
                    {
                        if(count($a) == 3){ 
                        ?>
                        <script>
                            sold(<?php echo $a[2]; ?>);
                            function sold(id) {
                                if (true) {
                                    $.ajax({
                                        url: '../farmers/queries/product.php',
                                        dataType: 'text',
                                        type: 'POST',
                                        data: {
                                            product_id: id,
                                            product_sold: ''
                                        },
                                        success: function(data) {
                                            console.log(data);
                                        },
                                        failure: function(data) {
                                            console.log("Problem While Moving to Sold.");
                                        }
                                    });
                                }
                            }

                        </script>
                         <?php
                         echo "Product is Added to Sold out Category". "<br>";
                         $message = "Your Product  with Id". $a[2]." is added to Sold Out Category";
                         include_once 'message.php';
                        }
                        else{
                            echo "Invalid Number of Fields". "<br>";
                            $message = "Invalid Number of Fields";
                            include_once 'message.php';

                        }

                    }
                    else
                    {
                        echo "Invalid Message!Please Enter in the Message Format.". "<br>";
                        $message = "Invalid Number of Fields"."<br><br>";
                        include_once 'message.php'; 
                    }       
                }
                else
                {
                    echo "Message Already Inserted into DB". "<br><br>";
                }
                
                
            }
            else{
                $query="select * from oc_msg where mobile='$mob' and msgtime='$time'";
                // echo $query."<br>";
                $q=mysqli_query($conn,$query);
                $rowcount=mysqli_num_rows($q);
                // echo $rowcount."<br>";
                if($rowcount < 1)
                {
                    $query1="INSERT INTO `oc_msg`(`mobile`, `msg`, `msgtime`,`status`) VALUES ('$mob','$str','$time','0')";
                    echo "Invalid user";
                    $q1=mysqli_query($conn,$query1);
                            if($q1){
                                echo "Not Found So Inserted". "<br><br>";
                                $message = "You are not a valid user.Please register in the website";
                                include_once 'message.php';
                            }
                    
                }
                else{
                    echo "Invalid user"."Already inserted"."<br>";
                }
            }
            
        } ?>
    </body>
</html>