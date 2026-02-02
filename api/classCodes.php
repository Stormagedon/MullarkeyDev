<?php 

$u = "classCodeUser";
//$u = "";

$p = "AAWTvBq94rvlWWzV"; // AErMedSDXn4U";    
//$p = "";

/*

CREATE TABLE IF NOT EXISTS `classCodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classCode` varchar(32) NOT NULL,
  `url` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

*/

// Connect to database
	$connection=mysqli_connect('localhost', $u, $p,'rest_api');

	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		case 'GET':
			// Retrive classCodes
			if(!empty($_GET["classCode"]))
			{
				$classCode = $_GET["classCode"];
				get_classCodes($classCode);
			}
			else
			{
				get_classCodes();
			}
			break;
		case 'POST':
			// Insert classCode
			insert_classCode();
			break;
		case 'PUT':
			// Update classCode
			$classCode = $_GET["classCode"];
			update_classCode($classCode);
			break;
		case 'DELETE':
			// Delete classCode
			$classCode = $_GET["classCode"];
			delete_classCode($classCode);
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function insert_classCode()
	{
		global $connection;
		$classCode=$_POST["classCode"];
		$url=$_POST["url"];

		if (mysqli_connect_errno())
  		{
  			$response=array(
				'status' => 2,
				'status_message' => "Failed to connect to MySQL: " . mysqli_connect_error(),
				'$classCode' => $classCode,
				'$url' => $url
			);
  			header('Content-Type: application/json');
			echo json_encode($response);
			return;
  		}

		$query="INSERT INTO classCodes SET classCode='{$classCode}', url='{$url}'";
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'classCode Added Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'classCode Addition Failed.',
				'$classCode' => $classCode,
				'$url' => $url
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function get_classCodes($classCode='0')
	{
		global $connection;
		$query="SELECT * FROM classCodes";
		if($classCode != '0')
		{
			$query.=" WHERE classCode='".$classCode."' LIMIT 1";
		}
//		echo $query;  // temp
//		echo '>>>' . $classCode . "<<<";
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function delete_classCode($classCode)
	{
		global $connection;
		$query="DELETE FROM classCodes WHERE classCode=".$classCode;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'classCode Deleted Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'classCode Deletion Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function update_classCode($classCode)
	{
		global $connection;
		parse_str(file_get_contents("php://input"),$post_vars);
		$classCode=$post_vars["classCode"];
		$price=$post_vars["price"];
		$quantity=$post_vars["quantity"];
		$seller=$post_vars["seller"];
		$query="UPDATE classCodes SET classCode='{$classCode}', url='{$url}' WHERE classCode=".$classCode;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'classCode Updated Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'classCode Updation Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	// Close database connection
	mysqli_close($connection);

?>