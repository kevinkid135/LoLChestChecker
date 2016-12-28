/**
 * Created by Kevin on 12/26/2016.
 */

function renew(r, id) {
    $("#fwotd").fadeOut("slow",
        function () {
            $.get("../php/fwotdCalc.php?region=" + r + "&summID=" + id, function (data) {
                // alert(data);
                // document.getElementById("fwotd").innerHTML = 'kappa';
                document.getElementById("fwotd").innerHTML = data;
                $("#fwotd").fadeIn("slow");
            });
        }
    );
    return false;
}

//TODO get array from php and allow different sorts