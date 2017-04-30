<?php
include_once('connect_db.php');

class Category
{
	private $db;
	public $row;
	public $name;
	public $parent_id;



	public function __construct($param_db)
	{
		$this->db = $param_db;
	}


	// function getInfo($username)
	// {
 //    $stmt = $this->db->prepare("SELECT * FROM users where username = ?");
 //    $stmt->execute(array($username));
 //    $this->row = $stmt->fetch();
 //    $this->username = $this->row['username'];
 //    $this->email = $this->row['email'];
 //    $this->id = $this->row['id'];
 //    $this->hashed_password = $this->row['password'];
	// }


	function getName($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM categories where id = ?");
		$stmt->execute(array($id));
		$row = $stmt->fetch();
		$this->name=$row['name'];
		return $this->name;
	}

	function getId($name)
	{
		$stmt = $this->db->prepare("SELECT * FROM categories where name = ?");
		$stmt->execute(array($name));
		$row = $stmt->fetch();
		$id=$row['id'];
		return $id;
	}

	// function getPrice($id)
	// {
	// 	$stmt = $this->db->prepare("SELECT * FROM products where id = ?");
	// 	$stmt->execute(array($id));
	// 	$row = $stmt->fetch();
	// 	$this->price=$row['price'];
	// 	return $this->price;
	// }


 	function getParent_id($id)
 	{
 		$stmt = $this->db->prepare("SELECT * FROM categories where id = ?");
 		$stmt->execute(array($id));
 		$row = $stmt->fetch();
 		$this->parent_id=$row['parent_id'];
 		return $this->parent_id;
 	}


	public function createCategory($name, $parent_id)//creer un produit
	{
	//$date= date("Y-m-d");
    $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id) VALUES (:name, :parent_id)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':parent_id', $parent_id);

    $stmt->execute();

    //echo "<div>Category created</div>";

	}


	function deleteCategory($param_id)
	{
      $stmt = $this->db->prepare("DELETE FROM categories WHERE id= ?");
      $stmt->execute(array($param_id));
  	}


	// public function deleteProduct($param_id)//effacer  un produit
	// {
	// $stmt = $this->db->prepare("DELETE FROM products WHERE (id = :id)");
 //    // $stmt->bindParam(':name', $name);
 //    // $stmt->bindParam(':price', $price);
 //    // $stmt->bindParam(':category_id', $category_id);
 //    $stmt->execute();

 //    echo "<div>Product deleted</div>";

	// }

	public function editCategory($name, $parent_id, $id)
	{
		//echo $name . $parent_id;
		$stmt = $this->db->prepare("UPDATE categories SET name = :name, parent_id = :parent_id WHERE id = :id");
	    $stmt->bindParam(':name', $name);
	    $stmt->bindParam(':parent_id', $parent_id);
	    $stmt->bindParam(':id', $id);
	    $stmt->execute();

	    //echo "<div>Category edited</div>";

	}


	public function displayCategory()
	{
		echo "<div>All categories are listed below.</div>";
		$stmt = $this->db->query("SELECT id, name, parent_id FROM categories ORDER BY id");

		foreach($stmt as $this->row)
		{
			echo "<tr><td>"
			. $this->row['id']
			. "</td><td>"
			. $this->row['name']
			. "</td><td>"
			. $this->row['parent_id']
			. "</td><td><a href='category_delete.php?del=" . $this->row['id'] . "'>delete</a></td>"
			. "<td><a href='category_edit.php?edit=" . $this->row['id'] . "'>edit</a></td></tr>";
   		}
   	}


   	public function dropDownCategory()
   	{
   		echo "<select name = 'category'>";
   		$stmt = $this->db->query("SELECT name FROM categories ORDER BY id");

   		foreach($stmt as $this->row)
   		{
   			echo "<option>" . $this->row['name'] . "</option>";
   		}
   		echo "</select>";
   	}
 }


//$product = new Product($db);
