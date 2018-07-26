<?php
	/**
	 * parent model
	 * my model
	 */
	class Model
	{
		
		public function get($where, $table, $select = "*")
		{
			include 'connection.php';
			$sql = "SELECT 
						".$select." 
					FROM ".$table."";
			if($where){
				$sql .= " WHERE ".$where;
			}

			$result = mysqli_query($conn, $sql);
			$data = array();

			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				$data = $row;
			}

			mysqli_close($conn);
			return $data;
		}

		public function get_all($where, $table, $select = "*")
		{
			include 'connection.php';
			$sql = "SELECT 
						".$select." 
					FROM ".$table."";
			if($where){
				$sql .= " WHERE ".$where;
			}

			$result = mysqli_query($conn, $sql);
			$data = array();

			if (mysqli_num_rows($result) > 0)
			{
				while ($row = mysqli_fetch_assoc($result)) {
			        $data[] = array_merge($row);
			    }

			}

			mysqli_close($conn);
			return $data;
		}

		public function do_query($query, $return = false)
		{
			include 'connection.php';
			$sql = $query;
			$result = $conn->query($sql);
			if (!$result === TRUE) {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

			mysqli_close($conn);
			if($return){
				return $result;	
			}else{
				return true;
			}
			
		}
	}
?>