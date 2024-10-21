/*SHOW TABLE CONTENT */
function DisplayTable(){
    const element = document.getElementById("content");
    element.scrollIntoView();
}

/*OPEN FORM & HIDE FORM*/
function openForm() {
    document.getElementById("Myform").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("Myform").style.display = "none";
  }
  
  /*VALIDATE FORM*/
  function validateForm() {
    var Name = document.forms["myForm"]["fname"].value;
    var Email = document.forms["myForm"]["email"].value;
    var Student = document.forms["myForm"]["student"].value;
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var nameRegex = /^[a-zA-Z]+ [a-zA-Z]+$/;
    
    
    if (Name == "") {
      alert("Name must be filled out");
      return false;
    }
    if (Email == "") {
      alert("Email must be filled out");
      return false;
    }
    if(Student == "") {
      alert("Associated Student must be filled out");
      return false;
    }
    if (!Email.match(emailRegex)) {
      alert("Please enter a valid email address");
      return false;
    }
    if(!nameRegex.test(Name)){
        alert('Please enter your fullname');
          return false;
    }
    if(!nameRegex.test(Student)){
        alert('Please enter associated fullname.');
          return false;
    }
    
    return true;
  
  }