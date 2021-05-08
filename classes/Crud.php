<?php
class Crud
{
		private $conn;
		public function __construct($connectionObject)
		{
			$this->conn = $connectionObject;
		}



		public function makesql($table, $rows='*', $where=null, $order=null, $join =null, $limit=null){
			$sql="SELECT $rows FROM $table"; 

			if($join!=null)
			{
				$sql .= $join;
			}

			if($where!=null)
			{
				$sql .= " WHERE " . $where;
			}

			if($order!=null)
			{
				$sql .= " ORDER BY " . $order;
			}

			if($limit!=null)
			{
				$sql .= " LIMIT " . $limit;
			}
	
		return $sql;
	}
		//method to select data from any table
		public function select($table, $rows='*', $where=null, $order=null, $join =null, $limit=null)
		{  

			//echo $sql;
			$sql = $this->makesql($table, $rows, $where, $order, $join , $limit);
			try 
			{
				$q = $this->conn->prepare($sql);  
				$q->execute();

				if($q->rowCount() > 0)
				{
					while($r = $q->fetch(PDO::FETCH_ASSOC))
					{ 
						$data[]=$r; 
				
					} 
					return $data; 
				}

				else
				{
					return false;
				}

				
				
					

			} 

			catch (PDOException $e) 
			{
				
				echo $e->getMessage();
			}


		}  

 



		//method to insert data into any table
		public function insert($table, $vmk=array())
		{  
			try
			{

					foreach ($vmk as $key => $val) {
						$rowsa[] = $key;
						$preps[] = ":".$key;

					}

					$sql = "INSERT INTO $table "; 
					$rows = implode(",", $rowsa);
					$value = implode(",", $preps);
					$sql .= " (" . $rows . ")";
					$sql .= " VALUES (" . $value . ")";

					//echo $sql;

					$q = $this->conn->prepare($sql); 

					
					foreach ($vmk as $key => &$val) 
					{
						
						$q->bindParam(":".$key, $val) ;

					}
					$q->execute();

					return true; 

			} 

		 	catch (PDOException $e) 
			{
				
				echo $e->getMessage();
			}
		}  



}




 ?>