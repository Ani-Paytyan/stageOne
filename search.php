<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<?php
$output = '';

$mysqli = new PDO('mysql:host=localhost;dbname=xmldata','root', '');
$search = $_GET["search"];

if ($mysqli) {
    $querySearchData = "SELECT addresses_street,addresses_cord_y,addresses_cord_x FROM xml WHERE addresses_street LIKE '%" . $search . "%';";
    $query = "SELECT addresses_street,addresses_cord_y,addresses_cord_x FROM xml";
    $resultSearch = $mysqli->query($querySearchData);
    $result = $mysqli->query($query);

    $addressesSearchArray = array();
    if ($resultSearch = $mysqli->query($querySearchData)) {
        while ($row = $resultSearch->fetch()) {
            array_push($addressesSearchArray, $row);
        }
    }
    $addressesArray = array();
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch()) {
            array_push($addressesArray, $row);
        }
    }


    foreach ($addressesSearchArray as $itemSearch) {
        foreach ($addressesArray as $key => $it) {
            $distance = round(sqrt(pow(($itemSearch['addresses_cord_x'] - $it['addresses_cord_x']), 2) + pow(($itemSearch['addresses_cord_y'] - $it['addresses_cord_y']), 2)), 2);
            if (!empty($distance)) {
                if ($distance < 5) {
                    $distanceGroup[$key]['first'] = $it['addresses_street'] . "(" . $distance . ")";
                } else if ($distance >= 5 && $distance < 30) {
                    $distanceGroup[$key]['second'] = $it['addresses_street'] . "(" . $distance . ")";
                } else {
                    $distanceGroup[$key]['thired'] = $it['addresses_street'] . "(" . $distance . ")";
                }
            }
        }
    }
    $body = '';
    if (!empty($distanceGroup)) {
        foreach ($distanceGroup as $item) {
            $body .= '<tr>
        <td>' . (isset($item['first']) ? $item['first'] : '') . '</td>
        <td>' . (isset($item['second']) ? $item['second'] : '') . '</td>
        <td>' . (isset($item['thired']) ? $item['thired'] : '') . '</td>
    </tr>';
        }
        $output = '<div class="table-wrapper">
        <table class="fl-table">
            <thead>
            <tr>
                <th>Distance < 5 Km</th>
                <th>Distance From 5 Km to 30 Km</th>
                <th>Distance more than 30 Km</th>
            </tr>
            </thead>
            <tbody>' . $body . '<tbody>
        </table>
    </div>';
    } else {
        $output = '<div class="alert alert-success">Result empty</div>';
    }
    echo $output;
}
?>