<?php
require_once __DIR__ . "/vendor/autoload.php";
include ("database.php");
$coursor=$client->find([],['projection'=>['name'=>1, '_id'=>0]]);
?>

<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Lab First</title>
  <script>

  var ajax = new XMLHttpRequest()
  var prev;

  function recordToStorage(ajaxText){
      var temp = localStorage.getItem('form2');
      if(temp == null){
          localStorage.setItem('form2', null);
          prev = ajaxText;
      }
      else{
        localStorage.setItem('form2', prev);
        prev = ajaxText;
      }
  }

  var ajax = new XMLHttpRequest();
function get1()
{
    if (!ajax)
     {
        alert("Ajax не инициализирован"); return;
     }
        var s1val = document.getElementById("league_id").value;
        ajax.onreadystatechange = Update;
        var params = 'league_id=' + encodeURIComponent(s1val);
        ajax.open("GET", "first.php?"+params, true);
        ajax.send(null); 
}

function Update()
{
    if (ajax.readyState == 4) 
    {
        if (ajax.status == 200) 
        {
            // если ошибок нет
            var select = document.getElementById('output');
            select.innerHTML = ajax.responseText;
        }
        else alert(ajax.status + " - " + ajax.statusText);
        ajax.abort();
    }
}


function get2()
{
    if (!ajax)
     {
        alert("Ajax не инициализирован"); return;
     }
        var s1val = document.getElementById("first-date").value;
        var s2val = document.getElementById("second-date").value;
        ajax.onreadystatechange = UpdateSelect2;
        var params = 'first-date=' + encodeURIComponent(s1val);
        var params2 = 'second-date=' + encodeURIComponent(s2val);
        ajax.open("GET", "second.php?"+params+"&"+params2, true);
        ajax.send(null);
}

function UpdateSelect2() {
    if(ajax.readyState == 4) {
        if(ajax.status == 200) {
            var res = document.getElementById("output2");
            var result = "";
            var rows = ajax.responseXML.firstChild.children;
            result+="<tr>"
            result+="<th>Id_Game</th>"
            result+="<th>Date_game</th>"
            result+="<th>Place</th>"
            result+="<th>Score</th>"
            result+="<th>FID_Team1</th>"
            result+="<th>FID_Team2</th>"
            result+="</tr>"
            for (var i = 0; i < rows.length; i++) {
                result += "<tr>";
                result += "<td>" + rows[i].children[0].textContent + "</td>";
                result += "<td>" + rows[i].children[1].textContent + "</td>";
                result += "<td>" + rows[i].children[2].textContent + "</td>";
                result += "<td>" + rows[i].children[3].textContent + "</td>";
                result += "<td>" + rows[i].children[4].textContent + "</td>";
                result += "<td>" + rows[i].children[5].textContent + "</td>";
                result += "</tr>";
                }
        res.innerHTML = result;
        }
    }
}

function get3() {
    if (!ajax) {
    alert("Ajax не инициализирован"); return;
    }
    var s1val = document.getElementById("team").value;
    ajax.onreadystatechange = UpdateSelect3;
    var params = 'team=' + encodeURIComponent(s1val);
    ajax.open("GET", "pre-third.php?"+params, true);
    ajax.send(null);
    }

    function UpdateSelect3() {
        if (ajax.readyState == 4) {
        if (ajax.status == 200) {
        // если ошибок нет
        var select = document.getElementById('player');
        select.innerHTML = ajax.responseText;
        }
        else alert(ajax.status + " - " + ajax.statusText);
        ajax.abort();
        }
    }
    
    function get4()
    {
    if (!ajax)
     {
        alert("Ajax не инициализирован"); return;
     }
        var s1val = document.getElementById("team").value;
        var s2val = document.getElementById("player").value;
        ajax.onreadystatechange = Update4;
        var params = 'team=' + encodeURIComponent(s1val);
        var params2 = 'player=' + encodeURIComponent(s2val);
        ajax.open("GET", "third.php?"+params+"&"+params2, true);
        ajax.send(null);
    }

    function Update4()
    {
    if (ajax.readyState == 4) {
        if (ajax.status == 200) {
            var rows = JSON.parse(ajax.responseText);
            var result = "";
            var res = document.getElementById("output3");
            result+="<tr>";
            result+="<th>ID_Game</th>";
            result+="<th>Name</th>";
            result+="</tr>";
            for (var i = 0; i < rows.length; i++) {
                result += "<tr>";
                result += "<td>" + rows[i].ID_Game + "</td>";
                result += "<td>" + rows[i].Name + "</td>";
                result += "</tr>";
            }
            res.innerHTML = result;
            }
        else { alert(ajax.status + " - " + ajax.statusText);
        ajax.abort(); }
    }
}


  </script>  
 </head>
 <body>
 
 <form name ="form1" method="get">
   <p><select id="select1" name="category_id">
   <option value="">Выбирите имя клиента:</option>
    <?php         
    foreach($coursor as $category) 
    { 
       echo '<option value="'. $category['name'] .'">'. $category['name'] .'</option>';
    }
    ?>
  </select>
   <p><input name="submit" type="button" value="Получить информацию" onclick="get1();"></p>
  </form>

  <div id="getselect1"></div>

 <form action="form2" method="get">
  <p>Введите диапазон времени:</p>
  <p><input type="button" value="Получить информацию" onclick="get3();"></p>
</form>

<table id="getselect3"></table>

<div id="getselect4"></div>

 <form  name="form3" method ="get">
  <input type="radio" id="balance" name="balance" value="balance">
  <label for="balance">Получить информацию об отрицательном счёте?</label><br>
  <p><input name = "submit" type="button" value="Получить информацию" onclick="get2();"/></p>
</form>

<table id="getselect2"></table>

</body>
</html>
