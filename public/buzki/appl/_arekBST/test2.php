<html>
<head>
<script language="javascript">
function test(id) {
  var element;
  element = document.getElementById(id);
  element.style.zIndex=element.style.zIndex+2;
}
</script>
</head>
<body>

<!--Warstwa strony glownej-->
<div style="position:absolute; background-color:white; width:100%; height:100%; z-index:2" id="yellow">
<table align="center">
  <tr>
   <td>
Glowna czesc strony <br/><br/><br/><input type="button" onclick="test('green'); this.disabled=true;" value="Pokaz formularz" />
   </td>
  </tr>
</table>
</div>
<!--Koniec warstwy strony glownej-->

<!--Warstwa formularza -->
<div style="position:absolute; background-color: #FFF; width:100%; height:100%; z-index:1" id="green">
 <table align="center">
  <tr>
   <td>
    warstwa z formularzem - musisz kliknac guzik<br/><br/><br/><br/><input type="button" onclick="test('yellow');" value="zapisz dane" />
   </td>
  </tr>
 </table>
</div>
<!--Koniec warstwy formularza-->

</body>
</html>