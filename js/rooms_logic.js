function showRooms() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("Table").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","./../../classes/Rooms/get_rooms.php",true);
        xmlhttp.send();
    
}



function onAjaxSuccess(obj){
        showRooms();
        console.log(obj);
}

function addRoom(){
    var newRoom = document.getElementsByName("AddName")[0].value;
    $.post(
        "./../../classes/Rooms/RoomLogic.php",
        {
            roomLogic: "add",
            arguments: [newRoom]
        },
        onAjaxSuccess
    );
    document.getElementsByName("AddName")[0].value = "";
}


function changeRoom(){
    var oldRoom = document.getElementsByName("OldName")[0].value;
    var newRoom = document.getElementsByName("NewName")[0].value;
    
    $.post(
        "./../../classes/Rooms/RoomLogic.php",
        {
            roomLogic: "change",
            arguments: [oldRoom, newRoom]
        },
        onAjaxSuccess
    );
    
    document.getElementsByName("OldName")[0].value = "";
    document.getElementsByName("NewName")[0].value = "";
}

function deleteRoom(){
    var oldRoom = document.getElementsByName("DeleteName")[0].value;
    
    $.post(
        "./../../classes/Rooms/RoomLogic.php",
        {
            roomLogic: "delete",
            arguments: [oldRoom]
        },
        onAjaxSuccess
    );
    document.getElementsByName("DeleteName")[0].value = "";
}