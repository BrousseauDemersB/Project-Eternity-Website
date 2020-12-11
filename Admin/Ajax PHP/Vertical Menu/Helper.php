<?php
    function RenderVerticalMenu(int $IndexMenu, int $IndexParent, string $Name, string $Link, string $Color, bool $OpenNewPage) : string
    {
        return "
            <tr>
                <td>
                    <input type='text' name='IndexMenu' value='$IndexMenu'/>
                </td>
                <td>
                    <input type='text' name='IndexParent' value='$IndexParent'/>
                </td>
                <td>
                    <input type='text' name='Name' value='". utf8_encode($Name) . "'/>
                </td>
                <td>
                    <input type='text' name='Link' value='". utf8_encode($Link) . "'/>
                </td>
                <td>
                    <input type='text' name='Color' value='". utf8_encode($Color) . "'/>
                </td>
                <td>
                    <input type='checkbox' id='OpenNewPage'><br/><br/>
                </td>
                <td>
                    <input type='button' value='Save changes' onclick='SaveVerticalMenuEntry(this, " . utf8_encode($IndexMenu) . ", " . utf8_encode($IndexParent) . ")'/>
                </td>
                <td>
                    <input type='button' value='Delete' onclick='DeleteVerticalMenuEntry(this, " . utf8_encode($IndexMenu) . ", " . utf8_encode($IndexParent) . ")'/>
                </td>
            </tr>";
    }
?>
