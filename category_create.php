<?php
include_once('connect_db.php');
include_once('User.php');
include_once('category.php');
include_once('header_nav.html');

if(isset($_POST['create']))
{
	$name = $_POST['name'];
	$parent_id = $_POST['parent_id'];
	if(isset($name) && isset($parent_id) && !empty($name) && !empty($parent_id) )
	{
		$category = new Category($db);
		$category->createCategory($name, $parent_id);
	}
else
{
  echo "you need to fill in each field.";
}
  header("Location: category_admin.php");
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
  <form  action="category_create.php" method="post">
    <div>
      <label for="name">Name: </label> <input type="text" name="name" id="name" />
    </div>

    <div>
      <label for="parent_id">Parent id :</label> <input type="text" name="parent_id" id="parent_id" />
    </div>
    <div>
      <input type="submit" name="create" value="Create category" />
    </div>
  </form>
</body>
</html
