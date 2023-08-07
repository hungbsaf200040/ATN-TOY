<?php
include('connect.php');
$get_categories = "SELECT * FROM category";
$categories = mysqli_query($conn, $get_categories);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $title = $_POST["name"];
  $price = $_POST["price"];
  $category = $_POST["category"];

  // Handle thumbnail file upload
  $thumbnail = $_FILES["thumbnail"];
  $thumbnailName = $thumbnail["name"];
  $thumbnailTmpName = $thumbnail["tmp_name"];
  $thumbnailPath = "acess/" . $thumbnailName;
  move_uploaded_file($thumbnailTmpName, $thumbnailPath);

  // Check if fields are not empty
  if (empty($title)) {
    $errors[] = "Product name is required";
  }
  if (empty($price)) {
    $errors[] = "Price is required";
  }
  if (empty($category)) {
    $errors[] = "Category is required";
  }
  if (empty($thumbnailName) || empty($thumbnailTmpName)) {
    $errors[] = "Thumbnail is required";
  } else {
    move_uploaded_file($thumbnailTmpName, $thumbnailPath);
  }

  if (empty($errors)) {

    // Process form submission
    $sql = "INSERT INTO products (prod_name, price, category_id, thumbnail) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdis", $title, $price, $category, $thumbnailPath); // string, double, integer, string

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Redirect to the homepage
      header("Location: index.php");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Create New Product</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">ATN Toys</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./create.php">New</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Create product form -->
  <form class="row container mx-auto py-3" method="POST" enctype="multipart/form-data">
    <h1>Create a new product</h1>

    <?php if (!empty($errors)) { ?>
      <div class="alert alert-danger" role="alert">
        <ul>
          <?php foreach ($errors as $error) { ?>
            <li><?php echo $error; ?></li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>

    <div class="mb-3">
      <label for="prod_name" class="form-label">Product name</label>
      <input type="text" class="form-control" id="prod_name" placeholder="Input product name" name="name">
    </div>
    <div class="mb-3">
      <label for="prod_price" class="form-label">Price</label>
      <input type="number" class="form-control" id="prod_price" placeholder="Input product price" name="price">
    </div>
    <div class="mb-3">
      <label for="category" class="form-label">Category</label>
      <select class="form-select" id="category" name="category">
        <option selected disabled hidden>Choose a category</option>
        <?php foreach ($categories as $category) { ?>
          <option class="text-dark" value="<?php echo $category["id"] ?>"><?php echo "#" . $category["cate_name"] ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="prod_img" class="form-label">Product image</label>
      <input type="file" class="form-control" id="prod_img" name="thumbnail">
    </div>
    <div class="mb-3 text-center">
      <a href="./index.php" class="btn btn-outline-secondary">Back to products</a>
      <button class="btn btn-success">Create</button>
    </div>
  </form>
</body>

</html>