 <?php
							$sql="select * from user";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
                                while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["UID"]}'>
										<td>{$row["NAME"]}</td>
										<td>{$row["EMAIL"]}</td>
										<td>{$row["MOBILE"]}</td>
										<td><a href='#' class='btn btn-primary edit' uid='{$row["UID"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' uid='{$row["UID"]}'>Delete</a></td>					
									</tr>";
								}
							}
						?>