<?php
session_start();
include_once('connect_db.php');
include_once('product.php');
include_once('User.php');
include_once('category.php');
include_once('header_nav.html');

$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin() == false)
{
	header("Location: index.php");
  exit();
}
else
{
		$product = new Product($db);


if(isset($_POST['edit']))
{
	$name = $_POST['name'];
	$price = $_POST['price'];
	$category_name= $_POST['category'];

	if(isset($name) && isset($price) && isset($category_name))
	{
		$product = new Product($db);
		$category = new Category($db);
		$category_id=$category->getId($category_name);
		$product->editProduct($name, $price, $category_id, $_POST['id']);
		header("Location: product_admin.php");
    exit();
	}

}
}
//
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit product page</title>
</head>
<body>
  <h1>Edit product page</h1>
  <div>
    Fill this form to edit a product.
  </div>
  <form  action="product_edit.php" method="post">
    <div>
      <label for="name">Name: </label> <input type="text" name="name" value=<?php echo $product->getName($_GET['edit']); ?> id="name" />
    </div>
    <div>
      <label for="price">Price: </label> <input type="number" name="price" value=<?php echo $product->getPrice($_GET['edit']); ?> id="price" />
    </div>
    <div>
      <label for="category">Category :</label> <?php
			$product->dropDownCategoryProduct();
			 ?>
			 <a href="https://localhost/php_rush.com/category_create.php">Create a new category</a>
    <div>
    	<input type="hidden" name="id" value="<?php echo $_GET['edit']?>"/>
    </div>
    <div>
      <input type="submit" name="edit" value="submit" />
    </div>
  </form>
</body>
</html>
