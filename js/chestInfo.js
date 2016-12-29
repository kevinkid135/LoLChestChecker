/**
 * Created by Kevin on 12/26/2016.
 */

function renew(r, id) {
    $("#fwotd").fadeOut("slow",
        function () {
            $.get("../php/fwotdCalc.php?region=" + r + "&summID=" + id, function (data) {
                document.getElementById("fwotd").innerHTML = data;
                $("#fwotd").fadeIn("slow");
            });
        }
    );
    return false;
}

function reloadPortraits() {
    // get text in search bar
    var input = document.getElementById('champSearch').value;

    // loop through all champions
    $('#portrait-list').find('div').each(function () {
        var champKey = $(this).attr('id');

        // check if champion name includes what has been searched
        if (masterArray[champKey]['name'].toUpperCase().includes(input.toUpperCase())) {
            document.getElementById(champKey).style.display = 'inline-block';
            // $("#" + champKey).show();
        } else {
            document.getElementById(champKey).style.display = 'none';
            // $("#" + champKey).hide();
        }
    });
}

//TODO allow different sorts