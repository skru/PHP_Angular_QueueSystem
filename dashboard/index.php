<?php


function callAPI($method, $url, $data){

    // utility function to callapis with curl

    $curl = curl_init();
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);                                                                                              
    return $result;
}

function timeDiff($date1, $date2) {

    //calculate serving time

    $date1 = date( 'Y-m-d h:i:s', strtotime($date1));
    $date2 = date( 'Y-m-d h:i:s', strtotime($date2));
     
    //Convert them to timestamps.
    $date1Timestamp = strtotime($date1);
    $date2Timestamp = strtotime($date2);
     
    //Calculate the difference.
    return $date2Timestamp - $date1Timestamp;
}

// initial call to ap[i on page load]
$get_data = callAPI('GET', 'http://localhost/engine/dapi/all_tickets.php', false);
$response = json_decode($get_data, true);

$dateArr = array();
$dateTrack = "";

foreach ($response as &$value) {
    if (isset($value["issuedTime"])){
        // parse issuedTime to display
        $parseDate = date( 'Y-m-d', strtotime($value["issuedTime"]));
        if ($dateTrack != $parseDate){
            array_push($dateArr, $parseDate);
            $dateTrack = $parseDate;
        }
    }
    
}

$totalTime = "";
$averageTime = "";

// date select form submitted
if( isset($_POST['dateSelect']) ){
    
    $date = $_POST["dateSelect"];

    // get issued count from api
    $ticketsIssuedResponse = callAPI('GET', 'http://localhost/engine/dapi/tickets_issued.php?date=' . $date, false);
    $ticketsIssued = json_decode($ticketsIssuedResponse, true)["count"];

    // get called count from api
    $ticketsCalledResponse = callAPI('GET', 'http://localhost/engine/dapi/tickets_called.php?date=' . $date, false);
    $ticketsCalled = json_decode($ticketsCalledResponse, true)["count"];

    // get no show count from api
    $ticketsNoShowResponse = callAPI('GET', 'http://localhost/engine/dapi/tickets_no_show.php?date=' . $date, false);
    $ticketsNoShow = json_decode($ticketsNoShowResponse, true)["count"];

    // get tickets by chosen date
    $filteredTickets = array_filter($response, function($value) use($date){
        if (isset($value["issuedTime"])){
            $parseDate = date( 'Y-m-d', strtotime($value["issuedTime"]));
            return $parseDate == $date;
        }
    });

    if(count($filteredTickets) > 0){
        // first and last tickets from date used to calculate total serving time
        $first = reset($filteredTickets);
        $last = end($filteredTickets);

        $firstTime = new DateTime($first['issuedTime']);
        $lastTime = new DateTime($last['servedTime']);

        $totalTime = $lastTime->diff($firstTime)->format("%H:%i:%s");

        // calculate average time 
        $avgArr = array();
        foreach ($filteredTickets as &$value) {

            if($value["served"] !== "0") {
                $difference = timeDiff($value["issuedTime"], $value["servedTime"]);
                array_push($avgArr, $difference);
            }
        }

        if(count($avgArr)){
            $average = array_sum($avgArr)/count($avgArr);
            $t = round($average);
            $averageTime = sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
        } else {
            $averageTime = "N/A";
        }
    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Dashboard</title>
  </head>
  <body>
    
    <div class="container">
        <br>
        <h1>Dashboard</h1>
        <br>
        <div class="row">
            <div class="col-md">

                <div class="card">
                  <div class="card-header">
                    Date:
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">View Ticket data by selecting a date</h5>
                    <br>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="dateSelect">Select Date</label>
                            <select class="form-control" name="dateSelect">
                            <?php
                                // iterate over date array to fill selectbox
                                foreach ($dateArr as &$value) {
                                    $selected = "";
                                    if($date == $value){
                                            $selected = "selected";
                                    }
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="view tickets">
                        </div>
                    </form>
                  </div>
                </div>
                <br>
                <div class="card">
                  <div class="card-header">
                    Tickets Count:
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Issued: <?php  echo $ticketsIssued; ?></h5>
                    <h5 class="card-title">Called: <?php  echo $ticketsCalled; ?></h5>
                    <h5 class="card-title">No Show: <?php  echo $ticketsNoShow; ?></h5>
                  </div>
                </div>
                <br>
                <div class="card">
                  <div class="card-header">
                    Times:
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Total serving Time: <?php  echo $totalTime; ?></h5>
                    <h5 class="card-title">Average Serving time: <?php  echo $averageTime; ?></h5>
                  </div>
                </div>
                <br>
                <div class="card">
                  <div class="card-header">
                    Graph:
                  </div>
                  <div class="card-body">
                    <canvas id="myChart" width="400" height="400"></canvas>
                  </div>
                </div>
            </div>

            <div class="col-md">
                
                <div class="card">
                  <div class="card-header">
                    Tickets
                  </div>
                  <div class="card-body">
                    <table style="width:100%">
                      <tr>
                        <th>Token #</th>
                        <th>Transaction #</th>
                        <th>Serving Time</th>
                      </tr>
                      <?php
                        foreach ($filteredTickets as &$value) {
                            // api call to get ticket transaction copunts
                            $transactionsResponse = callAPI('GET', 'http://localhost/engine/dapi/ticket_transactions.php?ticketId=' . $value['id'], false);
                            $transactions = json_decode($transactionsResponse, true);
                            if ($value["servedTime"] != "0000-00-00 00:00:00"){
                                // format to display in hours mins seconds
                                $t = round(timeDiff($value["issuedTime"], $value["servedTime"]));
                                $servingTime = sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
                             
                            } else {
                                $t = "";
                                $servingTime = "N/A";
                            }

                            echo '<tr><td>' . $value['tokenNumber'] . '</td><td>' . count($transactions) . '</td><td class="avgTicketNumber">' . $servingTime . '<span class="waitingTime" style="display:none;">' . $t . '</span></td></tr>';
                            
                            }
                        ?>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>


    <canvas id="myChart" width="400" height="400"></canvas>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script>
        $(function() {
            // using a javacript librabry to display graph
            var ctx = document.getElementById('myChart').getContext('2d');
            var tickets = [];
            $('.waitingTime').each(function() {
                //alert($(this).val());
                tickets.push($(this).text())
            });

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: tickets,
                    datasets: [{
                        label: '# of Votes',
                        data: tickets,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
  </body>
</html>