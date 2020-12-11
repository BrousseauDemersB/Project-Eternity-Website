<?php
function RenderAdminRightChoices(array $Data, string $DefaultRightName) : string
{
    $RightChoices = "<select>";
    for ($row = 0; $row < count($Data); $row++)
    {
        if ($Data[$row][1] == $DefaultRightName)
        {
            $RightChoices .= "<option selected='selected' value='" . $Data[$row][0] . "'>" . $Data[$row][1]  . "</option>";
        }
        else
        {
            $RightChoices .= "<option value='" . $Data[$row][0] . "'>" . $Data[$row][1]  . "</option>";
        }
    }
    $RightChoices .= "</select>";
    
    return $RightChoices;
}

function RenderUser(string $AdminRightName, string $Username, int $UserID, array $Data) : string
{
    return "
    <tr>
        <td>
        " . RenderAdminRightChoices($Data, utf8_encode($AdminRightName)). "
        </td>
        <td>
            <input type='text' name='Username' value='". utf8_encode($Username) . "'/>
        </td>
        <td>
            <input type='button' value='Save changes' onclick='SaveUser(this, " . utf8_encode($UserID) . ")'/>
        </td>
        <td>
            <input type='button' value='Delete' onclick='DeleteUser(this, " . utf8_encode($UserID) . ")'/>
        </td>
    </tr>";
}

function GetRightChoices(DatabaseHandler $Db) : array
{
    $sql = "SELECT RightID, RightName FROM Rights";
    $Data = array();
    $Counter = 0;
    foreach ($Db->Query($sql) as $row)
    {
        $Data[$Counter++]= [utf8_encode($row[0]), utf8_encode($row[1])];
    }
    
    return $Data;
}
?>
