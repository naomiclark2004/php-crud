<?php
class Menu
{
    protected $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function set_title($db)
    {
        $this->db = $db;
    }
    // get all info for each link in menu table with active status ASC
    // display in order as horizontal menu with working links
    // for each link show <a> tag with working url and name
    function showMenu()
    {
        $result = $this->db->getActiveLinks();
        if (mysqli_num_rows($result) > 0) {
            echo "<nav>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<a href='" . $row['link_url'] . "'>" . $row['link_name'] . "</a>";
            }
            echo "</nav>";
        }
    }
}
