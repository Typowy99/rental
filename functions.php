<?php
 echo " Dzisiaj jest " . date("l") . ". ";
?>


<?php
    require('admin/sql_connect.php');
    
    function get_motocykl($type){

        global $mysqli;

        switch($type){
            case 'avalible':
            $sql = "SELECT id,name,photo_url,type,price FROM motocykl WHERE avalible = 1";
            break;
            case 'unavalible':
            $sql = "SELECT motocykl.id,motocykl.name,motocykl.photo_url,motocykl.type,motocykl.price,reservations.to_date FROM motocykl INNER JOIN reservations ON motocykl.id = reservations.motocykl_id
            WHERE motocykl.avalible = 0";
            break;
            case 'select':
            $sql = "SELECT id,name FROM motocykl WHERE avalible = 1";
            break;
        }
       

       $result = $mysqli->query($sql);

       $rows = $result->fetch_all(MYSQLI_ASSOC);

       return $rows;
        
    }
    function generate_dashboard(){
        global $mysqli;

        $sql = "SELECT motocykl.name, clients.name, reservations.cost, reservations.to_date FROM reservations INNER JOIN motocykl ON reservations.motocykl_id = motocykl.id INNER JOIN clients ON clients.id = reservations.client_id";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
    function reserve($name, $surname, $phone, $motocykl_id, $termin,$days,$hours){
        global $mysqli;

        $from_date = $termin;
        
        $to_date = date('Y-m-d H:i',strtotime($from_date.'+ '.$days.' days + '.$hours.' hours'));

        $sql = "SELECT price,name,avalible FROM motocykl WHERE id = $motocykl_id";

        $result = $mysqli->query($sql);
        $row = $result->fetch_row();

        $price = $row[0];
        $motocykl_name = $row[1];
        $avalible = $row[2];

        if($avalible != 1){
            die('Samochód zajęty!');
        }

        $cost = ($days * 24 + $hours) * $price;
    
        $sql_2 = "INSERT INTO clients (`name`,`surname`,`phone`) VALUES (?,?,?)";


        if($statement = $mysqli->prepare($sql_2)){
            if($statement->bind_param('sss',$name,$surname,$phone)){
                $statement->execute();

                $client_id = $mysqli->insert_id;
               
                    $sql_3 = "INSERT INTO reservations (`client_id`,`motocykl_id`,`from_date`,`to_date`,`cost`) VALUES (?,?,?,?,?)";

                    if($statement_2 = $mysqli->prepare($sql_3)){
                        if($statement_2->bind_param('iissi',$client_id,$motocykl_id,$from_date,$to_date,$cost)){
                           
                            $statement_2->execute();
                            
                            $mysqli->query("UPDATE motocykl SET avalible = 0 WHERE id = $motocykl_id " );
                            
                           
                        } 
                    }
            }
        } else{
            die('Niepoprawne zapytanie'.$mysqli->err_message());
        }

    }

    function make_pay($name,$surname,$phone,$cost,$price,$motocykl_name,$payment_id){
        global $mysqli;        
        require_once 'lib/openpayu.php';
        require_once 'config.php';

    $order['continueUrl'] = 'http://localhost/rental/success.php'; //customer will be redirected to this page after successfull payment
    $order['notifyUrl'] = 'http://localhost/rental/order/OrderNotify.php';
    $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
    $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
    $order['description'] = 'motocykl Rent';
    $order['currencyCode'] = 'PLN';
    $order['totalAmount'] = $cost*100;
    $order['extOrderId'] = $payment_id; //must be unique!

    $order['products'][0]['name'] = $motocykl_name;
    $order['products'][0]['unitPrice'] = $price*100;
    $order['products'][0]['quantity'] = 1;

  
    //optional section buyer
    
    $order['buyer']['phone'] = $phone;
    $order['buyer']['firstName'] = $name;
    $order['buyer']['lastName'] = $surname;

    $response = OpenPayU_Order::create($order);
    $orderId = $response->getResponse()->orderId;
    $mysqli -> query("UPDATE payments SET orderId = $orderId WHERE id = $payment_id");
    header('Location:'.$response->getResponse()->redirectUri); //You must redirect your client to PayU payment summary page.
    }

?>