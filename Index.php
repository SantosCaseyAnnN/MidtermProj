<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calc</title>
</head>
<body>
    <form method="post" action = "">
        num1: <input type = "text" name = "num1"><br><br>
        num2: <input type = "text" name = "num2"><br><br>
        qty: <input type = "text" name = "qty"><br><br>

        <select name = "options">
            <option value = ""> Select an Option </option><br>
            <option value = "100"> Option 1 (price 100) </option>
            <option value = "200"> Option 2 (price 200) </option>
            <option value = "300"> Option 3 (price 300) </option>
        </select> <br> </br>

        <input type = "submit" name = "submit" value = "enter">
     </form> 

     <?php
        if(isset($_POST['submit'])){
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $qty = $_POST['qty'];
            $option = $_POST['options'];

            if(is_numeric($num1) && is_numeric($num2)){
                echo "The sum is: " . ($num1 + $num2) . "<br><br>";
                echo "The difference is: " . ($num1 - $num2) . "<br><br>";
                echo "The product is: " . ($num1 * $num2) . "<br><br>";
                if ($num2 != 0){
                    echo "The quotient is: " . ($num1/$num2) . "<br><br>";
                } else {
                    echo "The quotient is: undefined (division by zero)<br><br>";
                }
            }

            if($option != ""){
                echo "You selected Option " . ($option/100) . ". <br><br><br>";
                $total = $qty * $option;
                echo "The total price is: " . $total;
            }
        }
     ?>

</body>
</html>

