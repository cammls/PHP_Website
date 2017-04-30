
<?php
session_start();
include_once('connect_db.php');
include_once('product.php');
include_once('User.php');
include_once('header_nav.html');
include_once('category.php');
include_once('header_nav.html'); 

if(isset($_POST['create']))
{
	$name = $_POST['name'];
	$price = $_POST['price'];
	$category_name = $_POST['category'];
	if(isset($name) && isset($price) && isset($category_name) && !empty($name) && !empty($price) && !empty($category_name) )
	{

		$product = new Product($db);
		$category = new Category($db);
		$category_id=$category->getId($category_name);
		$product->createProduct($name, $price, $category_id);
    header("Location: product_admin.php");
    exit();
	}
else
{
  echo "you need to fill in each field.";
}

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>Admin product page</title>

</head>
<body>
  <h1>Admin product page</h1>
  <div>
    Fill this form to create a product.
  </div>
  <form  action="product_create.php" method="post">
    <div>
      <label for="name">Name: </label> <input type="text" name="name" id="name" required />
    </div>
    <div>
      <label for="price">Price: </label> <input type="number" name="price" id="price" required/>
    </div>
    <div>
      <label for="category">Category :</label>
      <?php
      $category = new Category($db);
      $category->dropDownCategory();
      ?>

      <a href="https://localhost/php_rush.com/category_create.php">Create a new category</a>
    </div>

    <div>
      <input type="submit" name="create" value="submit" />
    </div>
  </form>
</body>
</html
