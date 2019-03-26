var dat = "";

function Export(){
   /* $.post(
        "./../../classes/Importexport/ImportexportLogic.php",
        {
            importexportLogic: "export",
            arguments: []
        },
        function (obj){
            dat = obj;
            console.log(dat);
        });
    download(dat, 'schedule.csv', 'text/plain');*/
}

function Import(){
    var data;
    var file = $("#ImportFile")[0].files[0];
    if (file) {
        var r = new FileReader();
        r.addEventListener('load', function (e) {
            data = e.target.result;
            $.post(
            "./../../classes/Importexport/ImportexportLogic.php",
            {
                importexportLogic: "import",
                arguments: [data]
            },
            function (obj){
                console.log(obj);
            }
            );
        });
        r.readAsBinaryString(file);
        
        
    } else { 
        alert("Failed to load file");
    }
    
    
    
}

function download(text, name, type) {
  var file = new Blob([text], {type: type});
  a.href = URL.createObjectURL(file);
  a.style.visibility = "visible";
  a.download = name;
}

var data;
function readSingleFile() {
    var file = $("#ImportFile")[0].files[0];
    if (file) {
        var r = new FileReader();
        r.addEventListener('load', function (e) {
            data = e.target.result;
        });
        r.readAsBinaryString(file);
        
        
    } else { 
        alert("Failed to load file");
    }
    
}