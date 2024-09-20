<?php
// Simulate the previously selected dropdown value (from database or after form submission)
$previous_value = isset($_POST['my_select']) ? $_POST['my_select'] : 'default_value';
$previous_value2 = isset($_POST['my_select2']) ? $_POST['my_select2'] : 'default_value';
?>

<form action="" method="POST">
    <label for="my_select">Choose an 1 option:</label>
    <select name="my_select" id="my_select">
        <option value="option1" <?= $previous_value == 'option1' ? 'selected' : '' ?>>Option 1</option>
        <option value="option2" <?= $previous_value == 'option2' ? 'selected' : '' ?>>Option 2</option>
        <option value="option3" <?= $previous_value == 'option3' ? 'selected' : '' ?>>Option 3</option>
    </select>
    <label for="my_select">Choose an 2 option:</label>
    <select name="my_select2" id="my_select2">
        <option value="option11" <?= $previous_value2 == 'option11' ? 'selected' : '' ?>>Option 11</option>
        <option value="option22" <?= $previous_value2== 'option22' ? 'selected' : '' ?>>Option 21</option>
        <option value="option33" <?= $previous_value2 == 'option33' ? 'selected' : '' ?>>Option 31</option>
    </select>
    <input type="submit" value="Submit">
</form>