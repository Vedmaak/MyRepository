<?php
require 'Requests_library.php';

class Structure{
    public $place, $club, $games, $score;


    public function __constructor($r_place, $r_club, $r_games, $r_score){
        $this->place = $r_place;
        $this->club = $r_club;
        $this->games = $r_games;
        $this->score = $r_score;
    }
}

class Program
{
    public function startPoint($season){
        $this->getData($season);
    }

    private function getData($season) {
        $recievedData = (new getApi())->tournamentTableBySeasonID($season);
        $this->decodeJSON($recievedData);
    }

    public function decodeJSON($jsonString){
        $this->parseData(json_decode($jsonString, true, 2));
    }

    private function parseData($recievedData){
        $parsedArray = array();
        foreach($recievedData as $data){
            $structure = new Structure($data['place'], $data['club']['title'], $data['played'], $data['points']);
            $parsedArray[] = $structure;
        }

        $this->printOutList($parsedArray);
        return $parsedArray;
    }
    public function printOutList($parsedArray)
    {
        echo '<table border="0">';

        echo '<tr>';
        echo '<td width="30" align="center"><H6>М</H6></td>';
        echo '<td width="120" align="center"><H6>Команда</H6></td>';
        echo '<td width="50" align="center"><H6>И</H6></td>';
        echo '<td width="50" align="center"><H6>О</H6></td>';
        echo '</tr>';

        foreach($parsedArray as $data) {
            echo "<tr><td>{$data->place}</td>
            <td>{$data->club}</td>
            <td>{$data->games}</td>
            <td>{$data->score}</td></tr>";
        }
        echo "</table>";
    }
}

$program = new Program();
$program->startPoint(0, 0, 0);

?>
