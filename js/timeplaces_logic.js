function showTimeplaces() {
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
        xmlhttp.open("GET","./../../classes/Timeplaces/get_timeplaces.php",true);
        xmlhttp.send();
    
}

function showDays() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("DayTable").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","./../../classes/Timeplaces/get_days.php",true);
        xmlhttp.send();
    
}


function onAjaxSuccess(obj){
        showTimeplaces();
        console.log(obj);
}

function onAjaxSuccessDay(obj){
        showDays();
        console.log(obj);
}

function addTimeplace(){
    var addStart = document.getElementsByName("AddStart")[0].value;
    var addStop = document.getElementsByName("AddStop")[0].value;
    var addOddity = document.getElementById("AddType")[document.getElementById("AddType").selectedIndex].value;
    
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            timeplaceLogic: "add",
            arguments: [addStart, addStop, addOddity]
        },
        onAjaxSuccess
    );
    document.getElementsByName("AddStart")[0].value = "";
    document.getElementsByName("AddStop")[0].value = "";
}


function changeTimeplace(){
    var oldID = document.getElementsByName("OldID")[0].value;
    var newStart = document.getElementsByName("NewStart")[0].value;
    var newStop = document.getElementsByName("NewStop")[0].value;
    var newOddity = document.getElementById("NewType")[document.getElementById("NewType").selectedIndex].value;
    
    console.log()
    
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            timeplaceLogic: "change",
            arguments: [oldID, newStart, newStop, newOddity]
        },
        onAjaxSuccess
    );
    
    document.getElementsByName("OldID")[0].value = "";
    document.getElementsByName("NewStart")[0].value = "";
    document.getElementsByName("NewStop")[0].value = "";
}

function deleteTimeplace(){
    var oldID = document.getElementsByName("DeleteTimeplace")[0].value;
    
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            timeplaceLogic: "delete",
            arguments: [oldID]
        },
        onAjaxSuccess
    );
    document.getElementsByName("DeleteTimeplace")[0].value = "";
}



function addDay(){
    var addDay = document.getElementsByName("AddDay")[0].value;    
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            dayLogic: "add",
            arguments: [addDay]
        },
        onAjaxSuccessDay
    );
    document.getElementsByName("AddDay")[0].value = "";
}


function changeDay(){
    var oldDay = document.getElementsByName("OldDay")[0].value;
    var newDay = document.getElementsByName("NewDay")[0].value;
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            dayLogic: "change",
            arguments: [oldDay, newDay]
        },
        onAjaxSuccessDay
    );
    
    document.getElementsByName("OldDay")[0].value = "";
    document.getElementsByName("NewDay")[0].value = "";
}

function deleteDay(){
    var oldDay = document.getElementsByName("DeleteDay")[0].value;
    
    $.post(
        "./../../classes/Timeplaces/TimeplaceLogic.php",
        {
            dayLogic: "delete",
            arguments: [oldDay]
        },
        onAjaxSuccessDay
    );
    document.getElementsByName("DeleteDay")[0].value = "";
}