 //------------------------------------------MY FUNCTIONS
 //---document.getElementById
 function gtId(id){
 	return document.getElementById(id);
 }
 //---document.getElementById.value
  function gtIdVal(id){
 	return document.getElementById(id).value;
 }
//---getting Private,Public and Gov-Aided radios---ON ADD SCHOOL PAGE
 	 var xklCtgr=null;
    var radiosl = document.getElementsByName('xkl_categ');
    	for(var l = 0; l < radiosl.length; l++){
        	radiosl[l].onclick = function(){
          	xklCtgr=this.value;//----------fourth creteria
        	}
    	}
//------------------------- VAlid phone number
function valid_phone(inputtxt){
	var phone = gtIdVal(inputtxt);
	var lnt = phone.length;
	var sub = phone.substr(0, 3);
	const digits_only = string => [...string].every(c => '0123456789'.includes(c));
	if (lnt==10 && ((sub=='078')||(sub=='072')||(sub=='073'))&&digits_only(phone)&&(phone.substr(0, 1)==0)) {
		return true;
	}else{
		return false;
	}
}
//-------------Set Content
function setCont(elm,cnt){
	document.getElementById(""+elm+"").style.display='block';
	document.getElementById(""+elm+"").innerHTML="<strong>"+cnt+"</strong>";
	function clr(){
		document.getElementById(""+elm+"").style.display='none';
		document.getElementById(""+elm+"").innerHTML="";

	}
	setTimeout(clr,5000);

}
//------------- UNFINISHED Set Content
function setContent(elm,cnt){
	document.getElementById(""+elm+"").style.display='block';
	document.getElementById(""+elm+"").innerHTML="<strong>"+cnt+"</strong>";
}
//-------------Set Content With Duration
function setContDir(diration,elm,cnt){
	document.getElementById(""+elm+"").style.display='block';
	document.getElementById(""+elm+"").innerHTML="<strong>"+cnt+"</strong>";
	function clr(){
		document.getElementById(""+elm+"").style.display='none';
		document.getElementById(""+elm+"").innerHTML="";

	}
	setTimeout(clr,diration);

}

function successSetCont(elm,cnt){		//=========================== SUCCESSFULLY SET-CONTENT
	document.getElementById(""+elm+"").style.display='block';
	document.getElementById(""+elm+"").innerHTML="<strong style='color:green;font-weight:bolder'>"+cnt+"</strong>";
	function clr(){
		document.getElementById(""+elm+"").style.display='none';
		document.getElementById(""+elm+"").innerHTML="";

	}
	setTimeout(clr,5000);

}
function failSetCont(elm,cnt){		//=========================== FAILED SET-CONTENT
	document.getElementById(""+elm+"").style.display='block';
	document.getElementById(""+elm+"").innerHTML="<strong style='color:red;'>"+cnt+"</strong>";
	function clr(){
		document.getElementById(""+elm+"").style.display='none';
		document.getElementById(""+elm+"").innerHTML="";

	}
	setTimeout(clr,5000);

}
//.........................................................isEmpty().......................................
function isEmpty(vval){
	if (vval=="") {
		return true;
	}else{
		return false;
	}
}

//==================================== ENTERING ROLLNUMBER TO PROCEES
function continueRegModules(){
	var rollNumber = gtIdVal("rollnumber");
	var confRollNumber = gtIdVal("confrollnumber");
	if (!isEmpty(rollNumber) || !isEmpty(confRollNumber)) {
		if (rollNumber==confRollNumber) {
			$.ajax({url:"api/requests/students.php",
			type:"POST",data:{rollnumber:rollNumber,confirm_rollnumber:confRollNumber,cate:'login'},dataType:'json',cache:false,success:function(res){
				if (res.status===undefined) {
					document.getElementById("login_div").style.display="none";
					document.getElementById("welcome_div").style.display="block";
					document.getElementById("student_name").innerHTML=res.ms_names;
					document.getElementById("student_id").value=res.ms_id;

					var options = "";
					for (var i = 0; i < res.modules.length; i++) {
						options+="<label><span><input type='checkbox' class='modules' value="+res.modules[i].modules_id+">"+res.modules[i].modules_name+'</span></label><hr>';
					}
					document.getElementById("modules-form").innerHTML=options;

				}else{
					$("#response_cnt").html(res.message).css("color","red");
				}
				}
			});
		}else{
			failSetCont("response_cnt", "Roll-numbers mismatched ...");
		}

	}else{
		failSetCont("response_cnt", "All fields are required ...");
	}
}

//==================================== ENTERING ROLLNUMBER TO PROCEES
function submitRegModules(){
	var student = gtIdVal("student_id");
	// var modules = gtIdVal("select_modules");
	// var modArr = document.querySelectorAll('.modules');
	// var modArrays = [];
	// for(var i=0;i<modArr.length;i++){
	// 	if(modArr[i].hasAttribute("checked")) modArrays[i] = modArr[i].value;
	// }

	var sel = [];
	$('.modules').each(function(){
		if($(this).is(':checked')){
			sel.push($(this).val());
		}
		sel.toString();
	})
	//console.log("Student "+student+" mod arr "+sel);
	if (sel.length==0) {
		failSetCont("response_cnt_scnd","Choose modules ...");
	}else{
		$.ajax({url:"api/requests/students.php",
		type:"POST",data:{student:student,modules:sel,cate:'savemodule'},dataType:'json',cache:false,success:function(res){
			if (res.status=='ok') {
					// document.getElementById("login_div").style.display="none";
					// document.getElementById("welcome_div").style.display="none";
					// document.getElementById("resp_div").style.display="block";
					// successSetCont("#respp","Registered successfully!");
					alert("Registered successfully!");
					window.location.reload(true);
			}else{
				$("#response_cnt").html(res);
			}
			}
		});
	}
}