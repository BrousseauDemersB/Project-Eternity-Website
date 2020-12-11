<?php
    function RenderHomeMenu(int $Position, string $Text, string $FilePath, int $Colspan, int $Rowspan) : string
    {
        return "
            <tr>
                <td>
                    <input type='text' name='Position' value='$Position'/>
                </td>
                <td>
                    <input type='text' name='Text' value='". utf8_encode($Text) . "'/>
                </td>
                <td>
                    <input type='text' name='FilePath' value='". utf8_encode($FilePath) . "'/>
                </td>
                <td>
                    <input type='text' name='Colspan' value='Colspan'/>
                </td>
                <td>
                    <input type='text' name='Rowspan' value='Rowspan'/>
                </td>
                <td>
                    <input type='button' value='Save changes' onclick='SaveHomeMenuEntry(this, $Position)'/>
                </td>
                <td>
                    <input type='button' value='Delete' onclick='DeleteHomeMenuEntry(this, $Position)'/>
                </td>
            </tr>";
    }
?>
