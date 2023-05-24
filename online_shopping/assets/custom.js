function updateCartValues() {
  var product_id = $("input[name='cart_prod_id[]']")
    .map(function () {
      return $(this).val();
    })
    .get();
  var product_qty = $("input[name='cart_prod_qty[]']")
    .map(function () {
      return $(this).val();
    })
    .get();

  $.post(
    "update-cart.php",
    { cart_prod_id: product_id, cart_prod_qty: product_qty },
    function (result) {
      alert(result);
      window.location.reload();
    }
  );
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
