<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>register company</title>
</head>

<body>
    <!-- <div class="container-fluid bg-dark text-light py-1">
       <header class="text-center">
           <h1 class="display-6">Create Company</h1>
       </header> -->

    <!-- </div> -->
    <section class="container my-2 w-50 p-2">
        <form class="row g-3 p-3" action="insert.php" method="POST" enctype="multipart/form-data">
            <h1>Add Company</h1>
            <div class="col-md-6">
                <label class="form-label">Company name</label>
                <input type="text" class="form-control" name="comp_name" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" required>
                
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword4" name="password" required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input action type="file" class="form-control" name="image" required>
                
            </div>
            
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" class="form-control" id="inputEmail4" name="city" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">State</label>
                <input type="text" class="form-control" id="inputEmail4" name="state" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Country</label>
                <input type="text" class="form-control" id="inputEmail4" name="country" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Registration date</label>
                <input type="date" class="form-control" name="registration" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Expiry date</label>
                <input type="date" class="form-control" name="expiry" required>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </section>
</body>

</html>