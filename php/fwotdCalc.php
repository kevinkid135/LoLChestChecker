<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 12/24/2016
 * Time: 10:39 PM
 */
include 'riotapi.php';

/**
 * @param $region
 * @param $summID
 * @return false|string
 */
function timeUntilFwotd($region, $summID) {
    $t = fwotdTime($region, $summID) - time();
    if ($t > 0) {
        return gmdate('G \H:i \M', $t);
    } else {
        return '0';
    }
}

?>
<h1>First Win of the Day Calculator</h1>
<h2>Your FWOTD is in...</h2>
<section id="fwotdTime">
    <?php echo timeUntilFwotd('NA', 54392217) ?>
</section>

<!-- TODO Create countdown timer -->
<!--<script>-->
<!--    function countdown(t) {-->
<!--        var timeArr = t.split(":");-->
<!---->
<!--        var hr = timeArr[0] * 60 * 60;-->
<!--        var min = timeArr[1] * 60;-->
<!--        var sec = timeArr[2] * 1;-->
<!---->
<!--        var s = hr + min + sec - 1;-->
<!---->
<!--        if (s > 0) {-->
<!--            var newTime= '';-->
<!--            setTimeout(function () {-->
<!--                hr = (s / 3600) >> 0;-->
<!--                min = (s % 3600 / 60) >> 0;-->
<!--                sec = (s % 3600 % 60) >> 0;-->
<!--                newTime = hr + ":" + min + ":" + sec;-->
<!--                document.getElementById("fwotdTime").innerHTML = newTime;-->
<!--            }, 999);-->
<!--            countdown(newTime);-->
<!--        } else {-->
<!--            document.getElementById("fwotdTime").innerHTML = "FWOTD is up!";-->
<!--        }-->
<!--    }-->
<!--    countdown(document.getElementById("fwotdTime").innerHTML);-->
<!--</script>-->
