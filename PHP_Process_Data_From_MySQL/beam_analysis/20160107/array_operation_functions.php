<?php

	function createArray($m, $n, $v = 0)
	{
		$t = array_fill(0, $n, $v);
		$arr = array();
		for ($i = 0; $i < $m; $i++) 
		{ 
		    array_push($arr, $t); 
		} 	
		return $arr;
	}

	function showArray($arr, $m, $n = 1)
	{
		if ($n == 1)
		{
			for ($x = 0; $x < $m; $x++) 
			{
				showlongformat($arr[$x]);
				echo "\n";
			}
		}
		else
		{
			$k = 0;
			while ($k < $n)
			{
				$k1 = $k + 8;
				if ($k1 > $n) $k1 = $n;
				printf("Column from %d to %d\n", $k+1, $k1);
				for ($x = 0; $x < $m; $x++) 
				{
					for ($y = $k; $y < $k1; $y++) 
					{
						showlongformat($arr[$x][$y]);
					}
					echo "\n";
				}
				$k += 8;
			}
		}
	}

	function showlongformat($a)
	{
		$l = printf($a);
		for ($i = 0; $i < 20-$l; $i++)
			echo " ";
	}

	function removeRow($arr, $xv)
	{
		$v = 0;
		$A = array();
		for ($i = 0; $i < count($arr) - count($xv); $i++)
		{
			if ($i + $v == $xv[$v])
			{
				$v++;
			}
			$A[$i] = $arr[$i + $v];
		}
		return $A;
	}

	function removeCol($arr, $xv)
	{
		$A = array();
		for ($i = 0; $i < count($arr); $i++)
		{
			$A[$i] = removeRow($arr[$i], $xv);
		}
		return $A;
	}

	function replaceVec($arr, $xv, $v)
	{
		$A = $arr;
		for ($i = 0; $i < count($v); $i++)
			$A[$xv[$i]] = $v[$i];
		return $A;
	}

	function LUPsolve($src, $b)
	{
		$rows = count($b);
		$X = array_fill(0, $rows, 0.0);
		$P = array_fill(0, $rows, 0);
		$k = 0;
		$kd = 0;
		$T = 0;
		$t = 0.0;
		$Y = array_fill(0, $rows, 0.0);

		$A = createArray($rows, $rows);
		for ($i = 0; $i < $rows; $i++)
			for ($j = 0; $j < $rows; $j++)
				$A[$i][$j] = $src[$i][$j];

		//initialise X,Y
		for ($n = 0; $n < $rows; $n++)
		{
			$X[$n] = 0;
			$Y[$n] = 0;
		}
		//decompose
		for ($i = 0; $i < $rows; $i++)
		{
			$P[$i] = $i;
		}
		for ($k = 0; $k < $rows; $k++)
		{
			$p = 0;
			for ($i = $k; $i < $rows; $i++)
			{
				$t = $A[$i][$k];
				if ($t < 0) $t = -$t;
				if ($t > $p)
				{
					$p = $t;
					$kd = $i;
				}
			}
			if ($p == 0)
			{
				printf("singular Matrix, no possible solutions\n");
				return;
			}

			$T = $P[$kd];
			$P[$kd] = $P[$k];
			$P[$k] = $T;
			for ($i = 0; $i < $rows; $i++)
			{
				$t = $A[$kd][$i];
				$A[$kd][$i] = $A[$k][$i];
				$A[$k][$i] = $t;
			}
			for ($i = $k + 1; $i < $rows; $i++)
			{
				$A[$i][$k] = $A[$i][$k] / $A[$k][$k];
				for ($j = $k + 1; $j < $rows; $j++)
				{
					$A[$i][$j] = $A[$i][$j] - $A[$i][$k] * $A[$k][$j];
				}
			}
		}

		//now solve
		for ($n = 0; $n < $rows; $n++)
		{
			$t = 0;
			for ($m = 0; $m < $n; $m++)
			{
				$t += $A[$n][$m] * $Y[$m];
			}
			$Y[$n] = $b[$P[$n]] - $t;
		}
		for ($n = $rows - 1; $n >= 0; $n--)
		{
			$t = 0;
			for ($m = $n + 1; $m < $rows; $m++)
			{
				$t += $A[$n][$m] * $X[$m];
			}
			$X[$n] = ($Y[$n] - $t) / $A[$n][$n];
		}
		//X now contains the solution;
		return $X;
	}
?>
