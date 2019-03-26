function showSubjects() {
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
        xmlhttp.open("GET","./../../classes/Subjects/get_subjects.php",true);
        xmlhttp.send();
    
}



function onAjaxSuccess(obj){
        showSubjects();
        console.log(obj);
}

function addSubject(){
    var newSubject = document.getElementsByName("AddName")[0].value;
    $.post(
        "./../../classes/Subjects/SubjectLogic.php",
        {
            subjectLogic: "add",
            arguments: [newSubject]
        },
        onAjaxSuccess
    );
    document.getElementsByName("AddName")[0].value = "";
}


function changeSubject(){
    var oldSubject = document.getElementsByName("OldName")[0].value;
    var newSubject = document.getElementsByName("NewName")[0].value;
    
    $.post(
        "./../../classes/Subjects/SubjectLogic.php",
        {
            subjectLogic: "change",
            arguments: [oldSubject, newSubject]
        },
        onAjaxSuccess
    );
    
    document.getElementsByName("OldName")[0].value = "";
    document.getElementsByName("NewName")[0].value = "";
}

function deleteSubject(){
    var oldSubject = document.getElementsByName("DeleteName")[0].value;
    
    $.post(
        "./../../classes/Subjects/SubjectLogic.php",
        {
            subjectLogic: "delete",
            arguments: [oldSubject]
        },
        onAjaxSuccess
    );
    document.getElementsByName("DeleteName")[0].value = "";
}