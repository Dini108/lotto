<?php
	require('connect.php');
	require('functions.php');
	$content=file_get_contents('lotto.html');
	if(is_logged())
	{
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id=$_SESSION['id'];
			$szam=$_SESSION['szam'];
			if($_SESSION['volt']==0)
			{
				$sql="INSERT INTO valasztasok (felh, szam) VALUES ($id, $szam)";
				$result=mysqli_query($db,$sql);
			}
			else
			{
				$sql="UPDATE valasztasok SET szam=$szam WHERE felh=$id";
				$result=mysqli_query($db,$sql);
			}
			$szamok="Választását rögzítettük!";
			
		}
		else
		{
		
		$szamok= '<table>
						<tr >
							<th colspan=10>Számok</th>
						</tr>';			
		for($i=0; $i<9; $i++) 
		{
			for($j=1; $j<11; $j++)
			{
			$szam=$i*10+$j;
			$szamok.= "<td><a href='lotto.php?szam=$szam'>".$szam.'</a></td>';
			}
			$szamok.='</tr>
				 <tr>';
		}
		$szamok.='</tr>
					</table>';

		$id=$_SESSION['id'];
		
		$_SESSION['volt']=0;
		$sql="SELECT szam FROM valasztasok WHERE felh=$id";
		$result=mysqli_query($db, $sql);
		
		if(mysqli_num_rows($result)>0)
		{
			$_SESSION['volt']=1;
			$szam=mysqli_fetch_array($result);
			$szamok .='<br>Az ön által korábban kiválasztott szám: '.$szam['szam'];
			$_SESSION['szam']=$szam['szam'];
			var_dump($_SESSION['szam']);
			$gombszoveg="Változtat";
		}
		if(empty($_GET['szam']))
		{
			if($_SESSION['volt']==0)
				{
				$szamok.='<table>
						<tr>
							<td> Nincs kiválasztott szám</td>
						</tr>
						</table>';
				}
				else
				{
					$szamok.='<table>
						<tr>
							<td> Nincs új kiválasztott szám</td>
						</tr>
						</table>';
				}
				
		}
		else
			{
				$szam=$_GET['szam'];
				if($_SESSION['volt']==1)
				{
				$szamok .='<table>
							<tr>
								<td> Most kiválasztott szám: '.$szam.'</td>
							</tr>
							</table>';
				}
				else
				{
					$szamok .='<table>
							<tr>
								<td> Kiválasztott szám: '.$szam.'</td>
							</tr>
							</table>';
				}
				$_SESSION['szam']=$szam;
				
		}
		
		$szamok.="<form method='post' action='lotto.php'>
					<input type='submit' value='Mentés'>
					</form>";
	}
	}
	else
	{
		$szamok = "nincs bejelentkezve";
	}
	
	$content = str_replace("::lotto::", $szamok, $content);
	echo $content;