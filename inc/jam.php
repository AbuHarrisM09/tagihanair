<?php
/**
 * Time Display Helper
 * Provides JavaScript functions for displaying current time and date
 */
?>
<script type="text/javascript">
    // Update clock every second
    window.setTimeout("updateClock()", 1000);
    
    function updateClock() {
        var now = new Date();
        setTimeout("updateClock()", 1000);
        
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById("jam").innerHTML = hours + ":" + minutes + ":" + seconds;
    }
</script>

<script language="JavaScript">
    // Display full date in Indonesian format
    var daysOfWeek = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    var monthsOfYear = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    var today = new Date();
    var dayName = daysOfWeek[today.getDay()];
    var date = today.getDate();
    var monthName = monthsOfYear[today.getMonth()];
    var year = today.getFullYear();
    
    var fullDate = dayName + ", " + date + " " + monthName + " " + year;
</script>
