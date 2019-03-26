function showCourses() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("CourseTable").innerHTML = this.responseText;
                $.post(
                    "./../../classes/CoursesGroups/CourseGroupsLogic.php",
                {
                    courseLogic: "get",
                    arguments: []
                },
                function (obj){
                    var sel = document.getElementById("CourseOption");
                    while (sel.length > 0) {
                        sel.remove(sel.length-1);
                    }
                    console.log(obj);
                    var myobj = JSON.parse(obj);
                    for(var i = 0; i < myobj.length; i++) {
                        var opt = document.createElement('option');
                        opt.innerHTML = myobj[i]['Number'];
                        opt.value = myobj[i]['Number'];
                        sel.appendChild(opt);
                    }
                }
                );
            }
        };
        xmlhttp.open("GET","./../../classes/CoursesGroups/get_courses.php",true);
        xmlhttp.send();
    
}

function showGroups() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("GroupTable").innerHTML = this.responseText;
            }
        };
        var course = document.getElementById("CourseOption")[document.getElementById("CourseOption").selectedIndex].value;
        xmlhttp.open("GET","./../../classes/CoursesGroups/get_groups.php?c=" + course,true);
        xmlhttp.send();
    
}

function onAjaxCourseSuccess(obj){
        showCourses();
        console.log(obj);
}

function onAjaxGroupSuccess(obj){
        showGroups();
        console.log(obj);
}

function addCourse(){
    var newCourse = document.getElementsByName("AddCourse")[0].value;
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            courseLogic: "add",
            arguments: [newCourse]
        },
        onAjaxCourseSuccess
    );
    document.getElementsByName("AddCourse")[0].value = "";
}


function changeCourse(){
    var oldCourse = document.getElementsByName("OldCourse")[0].value;
    var newCourse = document.getElementsByName("NewCourse")[0].value;
    
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            courseLogic: "change",
            arguments: [oldCourse, newCourse]
        },
        onAjaxCourseSuccess
    );
    
    document.getElementsByName("OldCourse")[0].value = "";
    document.getElementsByName("NewCourse")[0].value = "";
}

function deleteCourse(){
    var oldCourse = document.getElementsByName("DeleteCourse")[0].value;
    
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            courseLogic: "delete",
            arguments: [oldCourse]
        },
        onAjaxCourseSuccess
    );
    document.getElementsByName("DeleteCourse")[0].value = "";
}



function addGroup(){
    var newGroup = document.getElementsByName("AddGroup")[0].value;
    var course = document.getElementById("CourseOption")[document.getElementById("CourseOption").selectedIndex].value;
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            groupLogic: "add",
            arguments: [course, newGroup]
        },
        onAjaxGroupSuccess
    );
    document.getElementsByName("AddGroup")[0].value = "";
}


function changeGroup(){
    var oldGroup = document.getElementsByName("OldGroup")[0].value;
    var newGroup = document.getElementsByName("NewGroup")[0].value;
    var course = document.getElementById("CourseOption")[document.getElementById("CourseOption").selectedIndex].value;
    
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            groupLogic: "change",
            arguments: [course, oldGroup, newGroup]
        },
        onAjaxGroupSuccess
    );
    
    document.getElementsByName("OldGroup")[0].value = "";
    document.getElementsByName("NewGroup")[0].value = "";
}

function deleteGroup(){
    var oldGroup = document.getElementsByName("DeleteGroup")[0].value;
    var course = document.getElementById("CourseOption")[document.getElementById("CourseOption").selectedIndex].value;
    
    $.post(
        "./../../classes/CoursesGroups/CourseGroupsLogic.php",
        {
            groupLogic: "delete",
            arguments: [course, oldGroup]
        },
        onAjaxGroupSuccess
    );
    document.getElementsByName("DeleteGroup")[0].value = "";
}