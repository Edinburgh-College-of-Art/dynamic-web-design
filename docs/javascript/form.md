---
title: Form
---

<script language="javascript" type="text/javascript">
<!--
function echeck(str) {

  let at="@"
  let dot="."
  let lat=str.indexOf(at)
  let lstr=str.length
  let ldot=str.indexOf(dot)
  if (str.indexOf(at)==-1){
     return false;
  }

  if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
     return false;
  }

  if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
      return false;
  }

   if (str.indexOf(at,(lat+1))!=-1){
      return false;
   }

   if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
      return false;
   }

   if (str.indexOf(dot,(lat+2))==-1){
      return false;
   }

   if (str.indexOf(" ")!=-1){
      return false;
   }

 	return true;

}

function checkEmail(myForm) {

    let emailID=document.form1.field2;
    let missing = "";
    let emailvalid = "";
    let flag = false;

  if(document.form1.field1.value=="" || document.form1.field1.value=="."){
      missing = missing + "Name" + "\n\n";
      flag = "true";
  }


  if(emailID.value=="" || emailID.value=="." ){
 	    missing = missing + "Email" + "\n\n";
      flag = "true";
  }


  if (echeck(emailID.value)==false){
       		emailvalid = emailvalid + "Email address has invalid format";
     		flag = "true";
  }

  if(emailID.value!=document.form1.confirmEmail.value){
      missing = missing + "You entered different email addresses" + "\n\n";
      flag = "true";
  }

  if(flag=="true"){
   	   alert("Please check you have completed these items:     " + "\n\n" + missing + emailvalid);
     return false;
     }

  else return true;
}
-->
</script>

<form name="form1" action="" method="post" onSubmit="return checkEmail(this);" id="form1">

<p><label for="field1">First name</label><br />
<input id="field1" maxlength="20" name="field1" value="." onFocus="if(this.value == '.') this.value = '';"/></p>

<p><label for="field2">Email address</label><br />
<input maxlength="200" id="field2" name="field2" value="." onFocus="if(this.value == '.') this.value = '';"/></p>
<p><label for="confirm">Confirm Email address</label><br />
<input maxlength="200" id="confirmEmail" name="confirmEmail" value="." onFocus="if(this.value == '.') this.value = '';"/></p>

<input type="submit" value="submit" class="submit"/>

</form>
