$(document).ready(function () {

  // initiate summernote
  $('#summernote').summernote({
    tabsize: 2,
    height: 120
  });

  //initialize jquery DataTable
  $('#table').DataTable({
    "pageLength": 25
  });

});


function getSubCategory(category_id){
  $.get("get-subcategory.php", {category_id:category_id}, function(result){
    $("#sub_category_id").html(result);
  });
}

function checkPassword(form) {
  password1 = form.password.value;
  password2 = form.confirm_password.value;
        
  // If Not same return False.    
  if (password1 != password2) {
      $("#error_msg").html("password and confirm password doesn't match")
      return false;
  }
}