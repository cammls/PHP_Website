<?php
session_start();
include_once('connect_db.php');
include_once('category.php');
include_once('User.php');
include_once('header_nav.html'); 
$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin() == false)
{
	header("Location: index.php");
  exit();
}
else
{
	$category= new Category($db);

if(isset($_POST['edit']))
{
	$name = $_POST['name'];
	$parent_id = $_POST['parent_id'];
  //echo $name . $parent_id;

	if(isset($name) && isset($parent_id))
	{
    //echo 'coucou';

		$category->editCategory($name, $parent_id, $_POST['id']);
		header("Location: category_admin.php");
		exit();
	}

}
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>Admin category page</title>

</head>
<body>
  <h1>Admin category page</h1>
  <div>
    Fill this form to create a category.
  </div>
  <form  action="category_edit.php" method="post">
    <div>
      <label for="name">Name: </label> <input type="text" name="name" value=<?php echo $category->getName($_GET['edit']); ?> id="name" />
    </div>

    <div>
      <label for="parent_id">Parent id :</label> <input type="text" name="parent_id" value=<?php echo $category->getParent_id($_GET['edit']); ?> id="parent_id" />
    </div>
    <div>
      <input type="hidden" name="id" value="<?php echo $_GET['edit']?>"/>
    </div>
    <div>
      <input type="submit" name="edit" value="Edit category" />
    </div>
  </form>
</body>
</html
