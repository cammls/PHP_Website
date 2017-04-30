<?php

include_once('connect_db.php');

class Product
{
	private $db;
	public $row;
	public $name;
	public $price;
	public $category_id;
	public $category_name;



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
		$stmt = $this->db->prepare("SELECT * FROM products where id = ?");
		$stmt->execute(array($id));
		$row = $stmt->fetch();
		$this->name=$row['name'];
		return $this->name;
	}


	function getPrice($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM products where id = ?");
		$stmt->execute(array($id));
		$row = $stmt->fetch();
		$this->price=$row['price'];
		return $this->price;
	}


 	function getCategory($id)
 	{
 		$stmt = $this->db->prepare("SELECT * FROM products where id = ?");
 		$stmt->execute(array($id));
 		$row = $stmt->fetch();
 		$this->category_id=$row['category_id'];
 		return $this->category_id;
 	}

 	function getCategoryName()
 	{
 		$stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
 		$stmt->execute(array($this->category_id));
 		$row = $stmt->fetch();
 		$this->category_name = $row['name'];
 		return $this->category_name;
 	}


	public function createProduct($name, $price, $category_id)//creer un produit
	{
	//$date= date("Y-m-d");
    $stmt = $this->db->prepare("INSERT INTO products (name, price, category_id) VALUES (:name, :price, :category_id)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();

    echo "<div>Product created</div>";

	}


	function deleteProduct($param_id)
	{
      $stmt = $this->db->prepare("DELETE FROM products WHERE id= ?");
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

	public function editProduct($name, $price, $category_id, $id)
	{
		//echo $name . $price . $category_id;
	$stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, category_id = :category_id WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    //echo "<div>Product edited</div>";

	}


	public function displayProduct()
	{
		echo "<div>All products are listed below.</div>";
		$stmt = $this->db->query("SELECT id, name, price FROM products ORDER BY id");

		foreach($stmt as $this->row)
		{
			echo "<tr><td>"
			. $this->row['id']
			. "</td><td>"
			. $this->row['name']
			. "</td><td>"
			. $this->row['price']
			. "</td><td><a href='product_delete.php?del=" . $this->row['id'] . "'>delete</a></td>"
			. "<td><a href='product_edit.php?edit=" . $this->row['id'] . "'>edit</a></td></tr>";
   		}
   	}
		
		public function dropDownCategoryProduct()
   	{
			$id= $this->getCategory($_GET['edit']);
			// echo $id;
			$name=$this->getCategoryName();

   		echo "<select name = 'category'>";
   		$stmt = $this->db->query("SELECT name FROM categories ORDER BY id");

   		foreach($stmt as $this->row)
   		{
				if ($name == $this->row['name'])
				{
					echo "<option selected='selected'>". $this->row['name'] ."</option>";
				}
				else
				{
						echo "<option>" . $this->row['name'] . "</option>";
				}

   		}

   		echo "</select>";
   	}
 }


//$product = new Product($db);
