/**
 * Hover effect
 * @param r
 * @param id
 * @returns {boolean}
 */
function renew(r, id) {
    $("#fwotd").fadeOut("slow",
        function () {
            $.get("../php/fwotdCalc.php?region=" + r + "&summId=" + id, function (data) {
                document.getElementById("fwotd").innerHTML = data;
                $("#fwotd").fadeIn("slow");
            });
        }
    );
    return false;
}

/**
 * hides/shows champions depending on user input
 */
function searchPortraits() {
    // get text in search bar
    var input = document.getElementById('champSearch').value;

    // loop through all champions
    $('#portrait-list').find('div').each(function () {
        var champKey = $(this).attr('id');
        // check if champion name includes what has been searched
        if (masterArray[champKey]['name'].toUpperCase().includes(input.toUpperCase())) {
            this.style.display = 'inline-block';
            // $("#" + champKey).show();
        } else {
            this.style.display = 'none';
            // $("#" + champKey).hide();
        }
    });
}

function toggleChestGranted(cb) {
    if (cb) {
        // show all champions where chestGranted = true
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['chestGranted']) {
                document.getElementById(champKey).style.display = 'inline-block';
            }
        });
    } else {
        // hide all champions where chestGranted = true
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['chestGranted']) {
                document.getElementById(champKey).style.display = 'none';
            }
        });
    }
}

function toggleChestNotGranted(cb) {
    if (cb) {
        // show all champions where chestGranted = false
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (!masterArray[champKey]['chestGranted']) {
                document.getElementById(champKey).style.display = 'inline-block';
            }
        });
    } else {
        // hide all champions where chestGranted = false
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (!masterArray[champKey]['chestGranted']) {
                document.getElementById(champKey).style.display = 'none';
            }
        });
    }
}
function toggleZeroMasteryPoints(cb) {
    if (cb) {
        // show all champions where mastery points = 0
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['championPoints'] == 0) {
                document.getElementById(champKey).style.display = 'inline-block';
            }
        });
    } else {
        // hide all champions where mastery points = 0
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['championPoints'] == 0) {
                document.getElementById(champKey).style.display = 'none';
            }
        });
    }
}
function togglePositiveMasteryPoints(cb) {
    if (cb) {
        // show all champions where mastery points = 0
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['championPoints'] > 0) {
                document.getElementById(champKey).style.display = 'inline-block';
            }
        });
    } else {
        // hide all champions where mastery points = 0
        $('#portrait-list').find('div').each(function () {
            var champKey = $(this).attr('id');
            if (masterArray[champKey]['championPoints'] > 0) {
                document.getElementById(champKey).style.display = 'none';
            }
        });
    }
}