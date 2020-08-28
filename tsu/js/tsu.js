angular.module('tsu', [])
  .controller('ticketController', function($scope, $http, ) {

    var tsuData = this;
    tsuData.serving = false;    //controls serving/idle mode
    tsuData.tickets = [];       // waiting tickets
    tsuData.servedTickets = []; // served tickets
    tsuData.noShowTickets = []; // no show tickets

    tsuData.ticketCount = 0;
    tsuData.servedTicketCount = 0;
    tsuData.noShowTicketCount = 0;
    tsuData.totalTicketCount = 0;

    tsuData.currentTicket = null; // ticket properties
    tsuData.currentTicketPayloads = [];
    tsuData.newPayloadText = "";
    tsuData.transactionCount = 1;
    tsuData.signature = "TELLER";

    var ticketTimer = new easytimer.Timer();
    var totalTimer = new easytimer.Timer();

    
    ticketTimer.addEventListener('secondsUpdated', function (e) {
        $('#ticketTimer').html(ticketTimer.getTimeValues().toString());
    });

    totalTimer.addEventListener('secondsUpdated', function (e) {
        $('#totalTimer').html(totalTimer.getTimeValues().toString());
    });

    tsuData.addTransaction = function() {
      tsuData.transactionCount++;
    };

    tsuData.calcTotals = function() {
      var ticketCount = tsuData.tickets.length;
      var noShowCount = tsuData.noShowTickets.length;
      var servedCount = tsuData.servedTickets.length;

      tsuData.ticketCount = ticketCount;
      tsuData.noShowTicketCount = noShowCount;
      tsuData.servedTicketCount = servedCount;
      tsuData.totalTicketCount = (ticketCount + servedCount + noShowCount);
    }

    tsuData.getTickets = function() {

      // calls teller api to get tickets for the current date

      tsuData.tickets = [];
      tsuData.servedTickets = [];
      tsuData.noShowTickets = [];

      // get date
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0');
      var yyyy = today.getFullYear();
      today = yyyy + '-' +mm + '-' + dd;

      $http({
            url: "http://localhost/engine/tapi/all_tickets.php?date="+today,
            method: "GET",
        }).then(function successCallback(response) {

                // populate ticket arrays
                var findUnserved = true;
                angular.forEach(response.data, function(value, key) {
                    if (value.served === "0" && value.noShow === "0"){
                      
                      if(findUnserved){
                        tsuData.currentTicket = value;
                        findUnserved = false;
                      }
                      tsuData.tickets.push(value);
                      
                    } if (value.served === "1"){
                      console.log("served")
                      tsuData.servedTickets.push(value);

                    } if (value.noShow === "1" && value.served === "0"){
                      tsuData.noShowTickets.push(value);
                      console.log("no show")
                    }
                });

                tsuData.calcTotals();
                
            }, function errorCallback(response) {
                $scope.error = response.statusText;
        });
    };
    // call api on initial page load
    tsuData.getTickets();
    // call api every 5 seconds to refresh waiting list
    window.setInterval(function(){
      tsuData.getTickets();
    }, 5000);


    tsuData.getPayloads = function(ticketId) {
      // get payloads for ticket by id
        $http({
            url: "http://localhost/engine/tapi/ticket_payloads.php?ticketId=" + ticketId,
            method: "GET",
        }).then(function successCallback(response) {
                console.log(response.data)
                if (response.data.message === 'No Payloads Found'){
                  tsuData.currentTicketPayloads = false;
                } else {
                  tsuData.currentTicketPayloads = response.data;
                }
                
            }, function errorCallback(response) {
              $scope.error = response.statusText;
        });
      }
 
    tsuData.callTicket = function(ticket) {
      // mark ticket as called
      ticketTimer.reset();
      totalTimer.start();
      tsuData.transactionCount = 1;

      // open bootstrap modal 
      $('#currentTicketModal').modal({backdrop: 'static', keyboard: false});

      $http({
            url: "http://localhost/engine/tapi/ticket_call.php",
            method: "PUT",
            data: {"id":ticket.id}
        }).then(function successCallback(response) {
                console.log(response.data)
                tsuData.serving = true;
                tsuData.currentTicket = ticket;
                console.log("curtrent:", tsuData.currentTicket)

                tsuData.getPayloads(tsuData.currentTicket.id);


            }, function errorCallback(response) {
              $scope.error = response.statusText;
        });
    };

    tsuData.serveTicket = function() {
      //mark ticket as served
      totalTimer.pause();

      $http({
          url: "http://localhost/engine/tapi/ticket_serve.php",
          method: "PUT",
          data: {"id":tsuData.currentTicket.id}
      }).then(function successCallback(response) {
              console.log(response.data)

              // add transactions
              for (var x=0; x<tsuData.transactionCount;x++){
                $http({
                    url: "http://localhost/engine/tapi/add_transaction.php",
                    method: "POST",
                    data: {"ticketId":tsuData.currentTicket.id}
                }).then(function successCallback(response) {
                        console.log(response.data)

                    }, function errorCallback(response) {
                      $scope.error = response.statusText;
                      console.log(response.statusText)
                });
              }
              tsuData.serving = false;
              tsuData.getTickets();
          }, function errorCallback(response) {
            $scope.error = response.statusText;
            console.log(response.statusText)
      });
      $('#currentTicketModal').modal('hide');
    };

    tsuData.noShowTicket = function() {
      // mark ticket as no show
      totalTimer.pause();

      $http({
          url: "http://localhost/engine/tapi/ticket_no_show.php",
          method: "PUT",
          data: {"id":tsuData.currentTicket.id}
      }).then(function successCallback(response) {
              console.log("RESPONS NO SHOW", response.data)
              tsuData.serving = false;
              tsuData.getTickets();
          }, function errorCallback(response) {
            $scope.error = response.statusText;
            console.log(response.statusText)
      });
      $('#currentTicketModal').modal('hide');
    };

    tsuData.addPayload = function(ticketId) {
      // add payload to ticket
      $http({
            url: "http://localhost/engine/tapi/add_payload.php",
            method: "POST",
            data: {"text":tsuData.newPayloadText, "ticketId":ticketId, "signature":tsuData.signature}
        }).then(function successCallback(response) {
                console.log(response.data)
                tsuData.getPayloads(ticketId);
                tsuData.newPayloadText = "";
            }, function errorCallback(response) {
              $scope.error = response.statusText;
              console.log(response.statusText)
        });
    };  

    tsuData.callRandom = function(tickets) {
      // call random ticket
      tsuData.callTicket(tickets[Math.floor(Math.random() * tickets.length)]);
    };  
  });