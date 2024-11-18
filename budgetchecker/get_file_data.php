<?php
// Retrieve the data from our text file.
$fileContents = file_get_contents('budgetchecker_data.txt');
$decoded      = json_decode($fileContents, true);
echo json_encode($decoded);