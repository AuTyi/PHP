<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$number1 = isset($_POST['number1']) ? $_POST['number1'] : '';
$number2 = isset($_POST['number2']) ? $_POST['number2'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = array("name" => "","email" => "", "feedback" => "","database" => "");

if($_POST){
    if(strlen($name)>0 && strlen($feedback)>0 && strpos($email,"@") && is_numeric($number1) && is_numeric($number2) && ($number1)+($number2)== 10) {

        // Attempt MySQL server connection to the db feedback
        $conn = new mysqli('localhost','root','root','feedback'); 
            //checking conection 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
        //Write to the table feedback
        $saved = $conn->query("INSERT INTO `feedback`(`name`, `email`, `feedback`) VALUES ('$name','$email','$feedback')");
            if($saved){
                    header('Location:' . $_SERVER['PHP_SELF'] . '?success=OK'); 
            }else{ 
				$error['database'] = "Error when saving"; //if not save to DB
			}

    } else { //cheking input one by one
        if(strlen($name) == 0){
            $error['name'] = 'Error';
        }
        if(strlen($email) == 0){
            $error['email'] = 'Error';
        }
        if(strlen($feedback) == 0){
            $error['feedback'] = 'Error';
        }
    }
}
if(strlen($success) == 0) {

?>

<!<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>html->php->form->db</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="style.css" />-->
    <style>
                body {
            margin: 50px;
        }
        input[type=text], input[type=email], textarea {
            display: block;
            min-width: 30%;
            margin: 20px 0;
            padding: 5px;
        }
        input[type=submit] {
            padding:5px 15px; 
            background:#ccc; 
            border:0 none;
            cursor:pointer;
            border-radius: 5px; 
        }
        span {
            color: red;
            display: inline;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Feedback form save to DB</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        Name <span><?php echo $error['name']; ?></span><input type="text" name="name" placeholder="Add Name" 
            value="<?php echo $name;?>" />
        Email <span><?php echo $error['email']; ?></span><input type="email" name="email" placeholder="Add Email"
            value="<?php echo $email;?>"/>
        Feedback <span><?php echo $error['feedback']; ?></span><textarea name="feedback" placeholder="Add Your feedback"
            value="<?php echo $feedback;?>"></textarea>
        Number1<input type="text" name="number1" placeholder="Number1 + Number2 must by 10" />
        Number2<input type="text" name="number2" placeholder="Number2 + Number1 must by 10"/>
        <span><?php echo $error['database']; ?></span>
        <input type="submit" value="Save"/>
    </form>
</body>
</html>
<?php 
  } else {
	  print "OK feedback saved to DB";
  }
?>	  