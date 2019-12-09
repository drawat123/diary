<?php
    include("data.php");
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(".toggleform").click(function(){
        $("#signupform").toggle();
        $("#loginform").toggle();
    })
    
    $('#datefield').bind('input propertychange', function() {
        $.ajax({
            method: "POST",
            url: "up2.php",
            data: { content: $('#datefield').val() }
            })
        
    });
    $('#con1').bind('input propertychange', function() {
        $.ajax({
            method: "POST",
            url: "up.php",
            data: { content: $('#con1').val() }
            })
    });
    $( document ).ready(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        today = yyyy+'-'+mm+'-'+dd;
        today1= <?php echo json_encode($row['created']); ?>;
        today1=today1.substr(0,today1.indexOf(' '));
        today=<?php echo json_encode($row['today']); ?>;
        document.getElementById("datefield").setAttribute("max", today);
        document.getElementById("datefield").setAttribute("min", today1);
        document.getElementById("datefield").value=today;
        });
    
    $('#datefield').bind('input propertychange', function() {
    $.get( "textfield.php", function( data ) {
                document.getElementById("con1").value=data;    
            });
    });
  
  </script>
  </body>
</html>

