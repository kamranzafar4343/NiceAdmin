<?php
if (isset($_POST['generateBarcode'])) {
    $barcodeText = htmlspecialchars(trim($_POST['barcodeText']));   

    if ($barcodeText != '') {
        echo '<img class="barcode" alt="' . $barcodeText . '" src="barcode.php?text=' . urlencode($barcodeText) . '&codetype=code128&orientation=horizontal&size=20&print=false"/>';
    } else {
        echo '<div class="alert alert-danger">Enter product name or number to generate barcode!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    .barcode{
        height: 50px;
        width: 160px;
    }
</style>
</head>
<body>
<div class="row">
    <div class="col-md-4">
        <form method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Name or Number</label>
                        <input type="text" name="barcodeText" class="form-control" value="<?php echo htmlspecialchars(@$_POST['barcodeText']); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <input type="submit" name="generateBarcode" class="btn btn-success form-control" value="Generate Barcode">
                </div>
            </div>
        </form>
    </div>
</div>
    
</body>
</html>
