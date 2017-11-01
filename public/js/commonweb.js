$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

var hexDigits = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 



  
$('.refreshstable').on('click',function(){
tableid= $(this).parents('.ibox-content').find('table').attr('id');
$("#"+tableid).DataTable().search('').draw();
});

function setToastNotification(objDataParams) {

    var header = "Deals en Route";
    if(typeof objDataParams.header != 'undefined') {
        header = objDataParams.header;
    }

    var message = "Welcome!!";
    if(typeof objDataParams.message != 'undefined') {
        message = objDataParams.message;
    }

    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success(header, message);

    }, 1000);
}

function removeElementFromArray(array, index) {
    
    //var arrarIndex = parseInt(parseInt(index) - 1);

    for(var i = array.length - 1; i >= 0; i--) {
        if(i === index) {
            array.splice(i, 1);
        }
    }

    return array;
}
