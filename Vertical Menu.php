<ul class="VerticalMenu">
	<?php
        class MenuInfo
        {
            private $Data = array();
            private $Name = "";
            private $Link = "";
            private $Color = "FFFFFF";
            private $OpenNewPage = "";
            private $IndexParent = "";
            
            public function __construct()
            {
                $a = func_get_args(); 
                $i = func_num_args(); 
                
                if (method_exists($this, $f = '__construct' . $i))
                { 
                    call_user_func_array(array($this, $f), $a); 
                } 
            }
            
            public function __destruct()
            {
                $this->Name = null;
                $this->Link = null;
                $this->Color = null;
                $this->OpenNewPage = null;
                $this->IndexParent = null;
                
                unset($this->Data);
            }
            
            public function __construct5(string $Name, string $Link, string $Color, string $OpenNewPage, string $IndexParent = NULL)
            {
                $this->Name = $Name;
                $this->Link = $Link;
                $this->Color = $Color;
                $this->OpenNewPage = $OpenNewPage;
                $this->IndexParent = $IndexParent;
            }
            
            public function Add(string $Index, MenuInfo $NewMenuInfo)
            {
                $this->Data[$Index] = $NewMenuInfo;
            }
            
            public function SortSubMenus()
            {
                // Asign children.
                foreach ($this->Data as $Key => $Value)
                {
                    if (strlen($Value->IndexParent) != 0 && $Value->IndexParent >= 0)
                    {
                        $this->Data[$Value->IndexParent]->Add($Key, $Value);
                    }
                }
                //Remove Unused children.
                foreach ($this->Data as $Key => $Value)
                {
                    if (strlen($Value->IndexParent) != 0 && $Value->IndexParent >= 0)
                    {
                        unset($this->Data[$Key]);
                    }
                }
            }
            
            private function Render()
            {
                echo
                "<li>
                    <a href='$this->Link' $this->OpenNewPage style='border-left : 5px solid #$this->Color'>
                        <span>$this->Name</span>
                    </a>";

                if (count($this->Data) > 0)
                {
                    echo "<ul>";
                    foreach ($this->Data as $Key => $Value)
                    {
                        $Value->Render();
                    }
                    echo "</ul>";
                }
                echo "</li>";
            }
            
            public function RenderRoot()
            {
                foreach ($this->Data as $Key => $Value)
                {
                    $Value->Render();
                }
            }
        }
        if (LoginCheck("Admin"))
        {
            echo
            "<li>
                <a href='$JavascriptWebsiteRoot/Admin/Admin%20homepage.php' style='border-left : 5px solid #AEAEAE'>
                    <span>Admin</span>
                </a>
            </li>";
        }
        
        echo "<link rel='stylesheet' href='$JavascriptWebsiteRoot/CSS/Vertical Menu.css'>";
        $Db = new DatabaseHandler();
		
		$sql = "select * from VerticalMenu;";
		$result = $Db->query($sql);
        $MenuRoot = new MenuInfo();
	
        foreach ($Db->Query($sql) as $row)
        {
            $Index = $row["IndexMenu"];
            $IndexParent = $row["IndexParent"];
            $Name = utf8_encode($row["Name"]);
            $Link = $row["Link"];
            $Color = $row["Color"];
            $OpenNewPage = $row["OpenNewPage"] ? "target='_blank' " : "";
            
            $MenuRoot->Add($Index, new MenuInfo($Name, $Link, $Color, $OpenNewPage, $IndexParent));
        }
        
        $MenuRoot->SortSubMenus();
        $MenuRoot->RenderRoot();
?>
</ul>