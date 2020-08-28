<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>TIU</title>
  </head>
  <body>
    <br>
    <div class="container">
        <h1>Ticket Issuing Utility</h1>
        <br>
        <div class="row text-center">

            <div class="col-md">
                <form id="ticketForm">
                    <table id="payloadTable" align=center class="form-group" width=100%>
                      <tr id="row1">
                        <td>
                          <input type="text" class="form-control addPayload"name="payload" placeholder="enter payload here"><br>
                        </td>
                      </tr>
                    </table>
                    <a href="" onclick="add_row(event);" class="btn btn-primary">Add additional payload</a>
                    <input class="btn btn-success" type="submit" value="Request Ticket">
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="ticketModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h5 class="modal-title">Ticket Issued</h5>
          </div>
          <div class="modal-body">
            <div class="jumbotron">
              <h1 class="display-4" id="modalTicketInfo"></h1>
            </div>
            <p ></p>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {


        var form = $('#ticketForm');

        form.submit(function(event) {
            
            $.ajax({
                type: "GET",
                url: "http://localhost/engine/tapi/create.php",
                success: function(response) {
                    console.log("init resp", response);
                    var ticketResponse = response;
                    $.each(form.serializeArray(), function(i, field) {
                        console.log("F VAL ", field.value)
                        if (field.value !== "") {
                            var data = JSON.stringify({
                                "text": field.value,
                                "ticketId": ticketResponse.id,
                                "signature": "KIOSK"
                            });
                            $.ajax({
                                type: "POST",
                                url: "http://localhost/engine/tapi/add_payload.php",
                                data: data,
                                success: function(response) {
                                    console.log("payload added ", response);
                                }
                            });
                        }
                    });
                    $("#modalTicketInfo").text("Ticket # " +ticketResponse.tokenNumber)
                    $("#ticketModal").modal({backdrop: 'static', keyboard: false});
                   
                   setTimeout(function(){
                        $("#ticketModal").modal('hide');
                         // clear payload text input
                        $(".addPayload").val("");
                        // // remove additional payload fields
                        $.each($("#payloadTable tr"), function( index, value ) {
                            if(index > 0){
                                value.remove();
                            }
                        });

                    }, 5000);
                }
            });

            
            event.preventDefault();

            
        });

    });

    function add_row(event) {
        event.preventDefault();
        var rowno = $("#payloadTable tr").length;

        if (rowno < 10) {
            rowno = rowno + 1;
            $("#payloadTable tr:last").after(
                "<tr id='row" + rowno + "'><td><input type='text' class='form-control' name='payload' placeholder='enter payload here'><br></td></tr>"
            );
        }
    }
    </script>
  </body>
</html>