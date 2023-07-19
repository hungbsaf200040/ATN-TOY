<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/index.css">
    <title>ATN-TOYS</title>
  </head>
  <body>
  <?php
include('connect.php');

  $currentURL = $_SERVER['REQUEST_URI'];

  $parts = explode('/', $currentURL);

  $id = end($parts);

  $getProductById = "SELECT * FROM products WHERE id = '$id'";
  $currentProduct = mysqli_query($conn, $getProductById);

  if ($currentProduct & mysqli_num_rows($currentProduct) > 0) { 
    // Fetch the data 
    $productData = mysqli_fetch_assoc($currentProduct);
  }
  if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //GET FORM DATA
    $title = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    //check if fields are not empty
    //if(empty($title)){
      //$errors[] = "Product name is required";
    //}
    //if(empty($price)){
     // $errors[] = "Price is required";
    //}
    //if(empty($category)){
      //$errors[] = "Category is required";
    //}
  
    $thumbnail = $_FILES["thumbnail"];
    $thumbnailName = $thumbnail["name"];
    $thumbnailTmpName = $thumbnail["tmp_name"];
    $thumbnailPath = "acess/".$thumbnailName;
    move_uploaded_file($thumbnailTmpName,$thumbnailPath);
  
  
    //if(empty($errors)){
      //process form submission
      $sql = "UPDATE products SET prod_name = ?, price = ?, category_id = ?, thumbnail ? WHERE id = ?"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdis",$title, $price, $category, $thumbnailPath);//string, double, integer, string
      //execute the prepared statement
      if($stmt->execute()){
        //Redirect to the homepage
        header("Location: ../index.php");
        exit();
      }else{
        echo"Error:".$sql."<br>".$conn->error;
      }
      //close the prepared statement and database connection
      $stmt->close();
    //}
  }
  ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">ATN-TOY</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./create.php">NEW</a>
              </li>
              <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li> -->
              <!-- <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
              </li> -->
            </ul>
            <!-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
          </div>
        </div>
      </nav>
      <form class="row container mx-auto py-3">
        <h1>update product</h1>
    <div class="col-12 mb-3">
        <label for="product_name" class="form-label">Product name</label>
        <input type="text" class="form-control" id="product_name" placeholder="input product name">
      </div>
      <div class="col-12 mb-3">
        <label for="price" class="form-label">Product price</label>
        <input type="number" class="form-control" id="price" placeholder="input price product">
      </div>
      <div class="col-12 mb-3">
        <label for="sold" class="form-label">Category</label>
        <select class="form-select" id="category" name="category" required>
          <option select disable value="">Choose a category</option>
          <option value="">#</option>
        </select>
      </div>
      <div class="col-12 mb-3">
        <label for="images" class="form-label">Product Img</label>
        <input type="file" class="form-control" id="images">
      </div>
      <div class="d-flex justify-content-center gap-3 mt-3">
      <button class="btn btn-success">update</button>
      <a href="./index.php" type="submit"class="btn btn-secondary">cancel</a>
    </div>
    </form>
    <script src="" async defer></script>
</body>
</html>