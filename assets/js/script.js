$('#reg').keyup(function(e){
	e.preventDefault();
	var reg = $(this).val();
	$.ajax({
		url:'inc/qr.php',
		data:{reg:reg},
		method:'POST',
		success:function(data){
			if(data.found=='yes'){
				$('#qrcode img').attr('src','qrcode/php/qr_img.php?d=cards.inkuge.com/payment_checker.php?student='+data.reg);
				$('#button').fadeIn();
				$('#names').fadeIn();
				$('#names').html(data.names);
				$('#download').val(data.reg);
			}else{
				$('#button').fadeOut();
				$('#names').fadeOut();
			}
		}
	})
})
$('#phone').keyup(function(e){
	e.preventDefault();
	var phone = $(this).val();
	$.ajax({
		url:'inc/qr.php',
		data:{phone:phone},
		method:'POST',
		success:function(data){
			if(data.found=='yes'){
				$('#qrcode img').attr('src','qrcode/php/qr_img.php?d=cards.inkuge.com/attendance.php?employee='+data.reg);
				$('#button').fadeIn();
				$('#names').fadeIn();
				$('#names').html(data.names);
			}else{
				$('#button').fadeOut();
				$('#names').fadeOut();
			}
		}
	})
})

$("#download").click(function(e){
	var name = $(this).val();
  html2canvas(document.querySelector("#qrcode")).then(canvas => {      
    saveImage(canvas.toDataURL(), 'qr_'+name+'.png');
  });
});

function saveImage(uri, filename) {
    var link = document.createElement('a');
    if (typeof link.download === 'string') {
        link.href = uri;
        link.download = filename;        
        document.body.appendChild(link);        
        link.click();
        document.body.removeChild(link);
    } else {
        window.open(uri);
    }
}
$('#print').click(function(){
$("#qrcode").printThis({
    debug: false,               // show the iframe for debugging
    importCSS: true,            // import parent page css
    importStyle: false,         // import style tags
    printContainer: true,       // print outer container/$.selector
    loadCSS: "",                // path to additional css file - use an array [] for multiple
    pageTitle: "",              // add title to print page
    removeInline: false,        // remove inline styles from print elements
    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
    printDelay: 333,            // variable print delay
    header: null,               // prefix to html
    footer: null,               // postfix to html
    base: false,                // preserve the BASE tag or accept a string for the URL
    formValues: true,           // preserve input/form values
    canvas: false,              // copy canvas content
    doctypeString: '...',       // enter a different doctype for older markup
    removeScripts: false,       // remove script tags from print content
    copyTagClasses: false,      // copy classes from the html & body tag
    beforePrintEvent: null,     // function for printEvent in iframe
    beforePrint: null,          // function called before iframe is filled
    afterPrint: null            // function called before iframe is removed
});
	
})


$('#payment').submit(function(e){
	e.preventDefault();
	var data = $(this).serialize();
	$.ajax({
		url:'driver/action.php',
		method:'POST',
		data:data,
		success:function(data){
			$('#payment').trigger('reset');
		}
	})
})
$('#login').submit(function(e){
	e.preventDefault();
	var data = $(this).serialize();
	$.ajax({
		url:'driver/action.php',
		method:'POST',
		data:data,
		success:function(data){
			if(data.status=='successful'){
				window.location=data.page;
			}
			if(data.status=='fail'){
				alert('Sorry! Username or Password incorect');
			}
		}
	})
})
$('#permission').submit(function(e){
	e.preventDefault();
	var data = $(this).serialize();
	$.ajax({
		url:'driver/action.php',
		method:'POST',
		data:data,
		success:function(data){
			if(data.status=='successful'){
				$('#permission').trigger('reset');
			}
			if(data.status=='fail'){
				alert('Sorry! Username or Password incorect');
			}
		}
	})
})

$('#print').click(function(){
	$("#attendance").printThis({
	    debug: false,               // show the iframe for debugging
	    importCSS: true,            // import parent page css
	    importStyle: false,         // import style tags
	    printContainer: true,       // print outer container/$.selector
	    loadCSS: "",                // path to additional css file - use an array [] for multiple
	    pageTitle: "",              // add title to print page
	    removeInline: false,        // remove inline styles from print elements
	    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
	    printDelay: 333,            // variable print delay
	    header: null,               // prefix to html
	    footer: null,               // postfix to html
	    base: false,                // preserve the BASE tag or accept a string for the URL
	    formValues: true,           // preserve input/form values
	    canvas: false,              // copy canvas content
	    doctypeString: '...',       // enter a different doctype for older markup
	    removeScripts: false,       // remove script tags from print content
	    copyTagClasses: false,      // copy classes from the html & body tag
	    beforePrintEvent: null,     // function for printEvent in iframe
	    beforePrint: null,          // function called before iframe is filled
	    afterPrint: null            // function called before iframe is removed
	});	
})

$('#faculty').change(function(e){
    e.preventDefault();
    var faculty = $(this).val();
    $.ajax({
        url:'driver/fetch.php',
        method:'POST',
        data:{faculty:faculty},
        success:function(data){
            $('#department').html(data);
        }
    })
})

$('#department').change(function(e){
    e.preventDefault();
    var faculty = $(this).val();
    $.ajax({
        url:'driver/fetch.php',
        method:'POST',
        data:{department:faculty},
        success:function(data){
            $('#class').html(data);
        }
    })
})