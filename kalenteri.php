<?php

    if (isset($_GET['ym'])) {
        list($current_year, $current_month) = explode("-", $_GET['ym']);
    } else {
        $current_year = date("Y");
        $current_month = date("m");
    }

    $current_date = date("Y-m-d");

    // Funktio, joka palauttaa edellisen kuukauden vuosi-kuukausi merkkijonon
    function previousMonth($year, $month) {
        $timestamp = strtotime($year . "-" . $month . "-01");
        $previous_month = date("Y-m", strtotime("-1 month", $timestamp));
        return $previous_month;
    }

    // Funktio, joka palauttaa seuraavan kuukauden vuosi-kuukausi merkkijonon
    function nextMonth($year, $month) {
        $timestamp = strtotime($year . "-" . $month . "-01");
        $next_month = date("Y-m", strtotime("+1 month", $timestamp));
        return $next_month;
    }

    setlocale(LC_TIME, 'fi_FI'); // Aseta kieleksi suomeksi

    // Tee kuukauden otsikko suomeksi
    $month_name = strftime('%B %Y', strtotime($current_year . "-" . $current_month . "-01"));

    // Laske kuukauden ensimmäisen päivän viikonpäivä (0 = maanantai, 6 = sunnuntai)
    $first_day = date("N", strtotime($current_year . "-" . $current_month . "-01"));

    // Luo taulukko
    echo "<table border='1' align='center'>";
    echo "<caption><b>" . $month_name . "</b></caption>";
    echo "<tr>";

    // Tulosta viikonpäivät suomeksi
    $weekdays = array("Ma", "Ti", "Ke", "To", "Pe", "La", "Su");
    foreach ($weekdays as $day) {
        echo "<td><small>" . $day . "</small></td>";
    }
    echo "</tr>";

    // Tulosta päivät
    $days_in_month = date("t", strtotime($current_year . "-" . $current_month . "-01"));
    $day_count = 1;
    echo "<tr>";

    // Täytä tyhjät solut ennen kuukauden ensimmäistä päivää
    for ($i = 1; $i < $first_day; $i++) {
        echo "<td></td>";
        $day_count++;
    }

    // Tulosta päivät
    for ($i = 1; $i <= $days_in_month; $i++) {
        // Tarkista, onko päivä nykyinen päivä
        if ($current_date == date("Y-m-d", strtotime($current_year . "-" . $current_month . "-" . $i))) {
            // Aseta päivä punaiseksi ja isommaksi
            echo "<td style='color: red; font-size: 1.5em;'><small>" . $i . "</small></td>";
        } else {
            // Muuten tulosta normaalisti
            echo "<td><small>" . $i . "</small></td>";
        }

        // Jos kyseessä on viikon viimeinen päivä (su), aloita uusi rivi
        if ($day_count % 7 == 0) {
            echo "</tr><tr>";
        }
        $day_count++;
    }

    // Täytä tyhjät solut kuukauden viimeisen päivän jälkeen
    while ($day_count % 7 != 1) {
        echo "<td></td>";
        $day_count++;
    }

    echo "</tr></table>";

    // Näytä "Edellinen kuukausi" ja "Seuraava kuukausi" -painikkeet alapuolella
    echo "<div style='text-align: center;'>";
    echo "<a href='?ym=" . previousMonth($current_year, $current_month) . "'>&lt;&lt; Edellinen kuukausi</a>";
    echo " | ";
    echo "<a href='?ym=" . nextMonth($current_year, $current_month) . "'>Seuraava kuukausi &gt;&gt;</a>";
    echo "</div>";
    echo "<div style='text-align: center;'>";
    echo "<a href='?ym=" . date("Y-m") . "'>Tämä kuukausi</a>";
    echo "</div>";
?>
