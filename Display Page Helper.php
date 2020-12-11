<?php
	function GetPagesInfo(string $Filter, bool $GroupByMods) : array
	{
		$Output = array();

		foreach ($ArrayImageEnseignant = glob($_SERVER['DOCUMENT_ROOT'] . $Filter) as $FilePath)
		{
			$Name = basename($FilePath, ".html");
			$ComponentFolder = basename(dirname($FilePath));
			$ModsFolder = basename(dirname($FilePath, 2));
			$NameWithFolder = $ComponentFolder . DIRECTORY_SEPARATOR . $Name;
			$RelativeFilePath = $ModsFolder . DIRECTORY_SEPARATOR . $ComponentFolder . DIRECTORY_SEPARATOR . basename($FilePath);

			$ArrayImage = glob($_SERVER['DOCUMENT_ROOT'] . "/Public/Images/$NameWithFolder.*");
			$ImagePath = "NULL";
			if (count($ArrayImage) == 1)
			{
				$ImageName = basename($ArrayImage[0]);
				$ImagePath = basename(dirname($ArrayImage[0])) . DIRECTORY_SEPARATOR . $ImageName;
			}
			
			if ($GroupByMods)
				$Output[$ModsFolder][] = array($Name => array($RelativeFilePath, $ImagePath));
			else
				$Output[] = array($Name => array($RelativeFilePath, $ImagePath));
		}

		return $Output;
	}

	function GetPage(array $ArrayPages) : string
	{
		ksort($ArrayPages);
		$Count = 0;
		$Output = "";
		foreach ($ArrayPages as $Pages)
		{
			$Name = key($Pages);
			$PageInfo = array_values($Pages)[0];
			$RelativeFilePath = $PageInfo[0];
			$Output = $Output .
			"<td width=\"25%\">
				<div>$Name</div>
				<a href='Display Page.php?PagePath=$RelativeFilePath'>";
			
			if (strcmp($PageInfo[1], "NULL"))
			{
				$ImageNameWithFolder = $PageInfo[1];
				$Filename = "/Public/Images/$ImageNameWithFolder";
				$Output = $Output . "<img src='$Filename' alt='Photo profile' align='middle'>";
			}
			else
				$Output = $Output . "<img src='/Public/Images/photoProfileDefault.png' alt='Photo profile' align='middle'>";
			
			$Output = $Output . "</a></td>";
			$Count++;
			
			if ($Count == 4)
			{
				$Output = $Output . "</tr><tr>";
				$Count = 0;
			}
		}

		return $Output;
	}

	function DisplayTable(bool $DisplayTableCaption, string $TableTitle, $TableContent)
	{
		echo "<table class='dimensionTable' id='Pages Table'>";
		if ($DisplayTableCaption)
		{
			echo "<caption>$TableTitle</caption>";
		}
		echo "<tr>";

		echo $TableContent;

		echo
		"	</tr>
		</table>";
	}

	function DisplayPages(string $OrderBy, string $ModsFilter, string $PagesFilter)
	{
		$Pages = GetPagesInfo("/Public/Mods/$ModsFilter/$PagesFilter/*.html", $OrderBy == "Mods");
		$NumberOfMods = count($Pages);
		$DisplayTableCaption = $NumberOfMods > 1;

		if ($OrderBy == "Mods")
		{
			ksort($Pages);

			foreach ($Pages as $ModName => $PageInMod)
			{
				DisplayTable($DisplayTableCaption, $ModName, GetPage($PageInMod));
			}
		}
		else
		{
			DisplayTable(false, "", GetPage($Pages));
		}
	}
?>
