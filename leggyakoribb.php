<?php
	require('connect.php');
	require('functions.php');
	$content=file_get_contents('leggyakoribb.html');
	if(is_logged())
	{
		$kiiras=$_SESSION['id'].'<br>';
		$kiiras.=$_SESSION['email'];
		$kiiras.= '<br><table>
						<tr >
							<thead colspan=5>Leggyakoribb számok</thead>
							<th>Szám</th>
							<th>Db</th>
						</tr>';
		$sql="SELECT szam, COUNT(szam) FROM valasztasok GROUP BY szam ORDER BY count(szam) DESC LIMIT 5";
		$result=mysqli_query($db,$sql);
		
		
		while($szam=mysqli_fetch_array($result, MYSQLI_NUM))
		{
			$kiiras.='<tr>';
			for($i=0; $i<2;$i++)
			{
				$kiiras.= "<td>".$szam[$i].'</td>';	
			}
			$kiiras.='</tr>';
		}
		
		$kiiras.='</table>';
	}
	else
	{
		$kiiras = "nincs bejelentkezve";
	}
	$content = str_replace("::kiiras::", $kiiras, $content);
	echo $content;