$(document).ready ( function(){
    showCourses();
    showDates();
});

var time;
var day;
var subj;
var room;
var course;
var oddity = 0;
var group;

function showCourses() {        
     $.post(
         "./classes/Index/IndexLogic.php",
     {
         indexLogic: "getCourses",
         arguments: []
     },
     function (obj){
         var sel = document.getElementById("Course");
         while (sel.length > 1) {
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

function showDates() {        
      $.post(
         "./classes/Index/IndexLogic.php",
     {
         indexLogic: "getDays",
         arguments: []
     },
     function (obj){
         var sel = document.getElementById("Day");
         while (sel.length > 1) {
             sel.remove(sel.length-1);
         }
         console.log(obj);
         var myobj = JSON.parse(obj);
         for(var i = 0; i < myobj.length; i++) {
             var opt = document.createElement('option');
             opt.innerHTML = myobj[i]['Name'];
             opt.value = myobj[i]['Name'];
             sel.appendChild(opt);
         }
     }
     );
}


function SelectCourse() {   
    course = document.getElementById("Course")[document.getElementById("Course").selectedIndex].value;
    
     $.post(
         "./classes/Index/IndexLogic.php",
     {
         indexLogic: "getGroups",
         arguments: [course]
     },
     function (obj){
         var sel = document.getElementById("Group");
         while (sel.length > 1) {
             sel.remove(sel.length-1);
         }
         console.log(obj);
         var myobj = JSON.parse(obj);
         for(var i = 0; i < myobj.length; i++) {
             var opt = document.createElement('option');
             opt.innerHTML = myobj[i]['Name'];
             opt.value = myobj[i]['Name'];
             sel.appendChild(opt);
         }
     }
     );
    ReloadTable();
}


function ReloadTable(){
    course = document.getElementById("Course")[document.getElementById("Course").selectedIndex].value;
    day = document.getElementById("Day")[document.getElementById("Day").selectedIndex].value;
    oddity = document.getElementById("Oddity")[document.getElementById("Oddity").selectedIndex].value;
    group = document.getElementById("Group")[document.getElementById("Group").selectedIndex].value;
    if(day != -1 && course != -1)
        FillCourseDay(course, day, oddity, group);
    else
        document.getElementById("TableDiv").innerHTML = "";
}


function FillCourseDay(course, day, oddity, group){
   if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("TableDiv").innerHTML = this.responseText;
                this.responseText = "";
            }
        };
        xmlhttp.open("POST","./classes/Index/get_schedule.php", true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        var coursebody = 'course=' + encodeURIComponent(course);
        var daybody = '&day=' + encodeURIComponent(day);
    
        var body = coursebody + daybody;
        if(oddity != -1)
            body += '&oddity=' + encodeURIComponent(oddity)
        if(group != -1)
            body += '&group=' + encodeURIComponent(group)
    
    
        xmlhttp.send(body);
}