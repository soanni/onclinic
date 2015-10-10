$(document).ready(function(){
    var $sfield = $('#username_patient').autocomplete({
        source: function(request, response){
            var url = "getLastFirstNames";
            $.post(url, {data:request.term}, function(data){
                response($.map(data, function(names) {
                    return {
                        value: names.fullname
                    };
                }));
            }, "json");
        },
        minLength: 2,
        autofocus: true
    });
});

function addRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;

    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for(var i = 0; i < colCount; i++) {
        var newCell = row.insertCell(i);
        newCell.innerHTML = table.rows[1].cells[i].innerHTML;
    }
}

function deleteRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    if(rowCount == 2){
        alert('You can not delete the only row');
    }else{
        table.deleteRow(rowCount-1);
    }
}

