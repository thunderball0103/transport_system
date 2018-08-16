$(document).ready(function(){

    //input formation check
    $(':input').change(function(){
        if( $('#start_date').val().indexOf(' ')>=0 || $('#end_date').val().indexOf(' ') >=0){
            alert("Date does not allowed space!");
        }
        else{
            window.location.href='filter_by_date?start_date="'+$('#start_date').val()+'"&end_date="'+$('#end_date').val()+'"';
        }   
    })

    //update database with xml every 20mins
    $.ajax({
        url: 'update_db_xml',

    }).done(function(){
        console.log('updated successfuly');
    })
})