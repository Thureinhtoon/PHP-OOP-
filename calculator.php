<form method="post">
<label for="num1">Enter Number1</label>
<input type="number" name="num1" id="num1"><br>
<label for="num2">Enter Number2</label>
<input type="number" name="num2" id="num2"><br>
<select name="operation" id="op">
    <option value="+">+</option>
    <option value="-">-</option>
    <option value="*">*</option>
    <option value="/">/</option>
</select><br>
<input type="submit" value="calculate" name="submit">
</form>
<?php
if(isset($_POST['submit'])){
    $num1 =(int) $_POST['num1'];
    $num2 =(int) $_POST['num2'];
    $oper = $_POST['operation'];

    switch($oper){
        case'+':echo $num1 + $num2;
        break;
        case '-':echo $num1 - $num2;
        break;
        case '*':echo $num1 * $num2;
        break;
        case '/' :echo $num1 / $num2;
    }
}
?>