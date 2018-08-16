
<?php echo $map['html']; ?>

<div id="asign_dialog">
    <button class="go_btn" 
        onclick='location.href="update_delivered?up_town=" + 
            $(this).parent().find(".area_sel").val() + "&color=" + 
            $(this).parent().find(".route_sel").val() + "&name=" + 
            $(this).parent().find("#dialog_name").text()'>
    X</button>
    <label>Asign to Area : </label>
    <select class="area_sel">
        <option>Aarhus</option>
        <option>Varde</option>
        <option>Viborg</option>
        <option>Videbaek</option>
        <option>Ulfborg</option>
        <option>Ringkobing</option>
    </select><br>
    <label>Asign to Route : </label>
    <select class="route_sel">
        <option>darkred</option>
        <option>red</option>
        <option>blue</option>
        <option>lightblue</option>
        <option>green</option>
        <option>lightgreen</option>
    </select><br><br>
    <p id="dialog_name"></p>
    <p id="dialog_address"></p>
    <p id="dialog_zipcode"></p>
    <p id="dialog_town"></p>
    <p id="dialog_phone"></p>
</div>


