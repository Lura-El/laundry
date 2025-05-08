$(function() {

  //front page nav buttons

  $('.navButton').click(function() {

      $('.navButton').removeClass('active'); 
      $(this).addClass('active');
      
      $('.modal').hide();
      
     let targetForm = $(this).data('target');
     $(targetForm).show();

  });
  
// terms & conditions
  $('#term').click(function() {
    $('#stmt').show();
    $('.close').click(function() {
      $('#stmt').hide();
    })
  })

//forget password

$('#forgetpw').click(function() {
  $('#forgetpwform').show();
  $('#login').hide();
    $('.fclose').click(function(){
      $('#forgetpwform').hide();
      $('#login').show();
    })
  
})

// end of jquery
}); 

// checkbox
const input = document.querySelector("#email");
const checkbox = document.querySelector('#checkbox');
const button = document.querySelector('.register-btn');
const term = document.querySelector('#term');

window.onload = function() {
  checkbox.checked = false;
  input.value = " ";
}

    checkbox.addEventListener('change', function () {

      if (!this.checked) {
        button.disabled = true;
        button.style.pointerEvents = 'none';
        term.style.color = 'red';
      } else {
        button.disabled = false;
        button.style.pointerEvents = 'auto';
        term.style.color = 'blue';
      }
    });

    // Initial check to ensure button state is correct on page load
    button.disabled = !checkbox.checked;
    button.style.pointerEvents = checkbox.checked ? 'auto' : 'none';

