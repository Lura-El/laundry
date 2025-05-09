$(function(){
 // nav buttons

   
    $('#servicepricetab').show();

    $('.navtwobtns').on('click',function() {

        $('.navtwobtns').removeClass('active'); 
        $(this).addClass('active');
        
        $('.tab').hide();
        
       let targetForm = $(this).data('target');
       $(targetForm).show();
    
    });
   
   // book a service 

   $('#edit').on('click', function() {
      let targetdiv = $(this).data('target');
      $(targetdiv).toggle();
  });
  
   const defaultcontact = document.querySelector("#defaultcontact div");

   if(defaultcontact.textContent !== ""){
      $('#defcon-form').hide();
      $('#defaultcontact').show();
   }

   $('#setdefault').on('click', function() {
      if (defaultcontact.textContent !== '') {
          $('#defcon-form').hide();
      }
  });
   
   //order tracking

  function formatDate(date) {
    const dateObj = new Date(date);
    const options = { 
        month: 'short', 
        day: '2-digit', 
        year: '2-digit', 
        hour: 'numeric', 
        minute: '2-digit', 
        hour12: true 
    };
    return dateObj.toLocaleString('en-US', options);
  }

 
  $('.track').click(function(){

    $.get("/../laundry/customer/order.track.php", function(data) {

      console.log(data);

    let orderinfo = "";

    let filterData = data.filter(result => result.status !== "Completed");

      if(filterData.length < 3){
        $("#trackorder").css("height", "50vh");
      }

      const trackStatuses = document.querySelectorAll('.track-status');

      data.forEach(result => {

        const date = result.pick_up_time;

        if(result.status !== "Completed"){  
          orderinfo += `
          <br> Service Id: ${result.service_id} <br>
          Service: ${result.service} <br>
          Pickup time: ${formatDate(date)} <br>
          Paid amount: ${result.paid} <br>
          Status: ${result.status} <br>
      `;

      trackStatuses.forEach(trackStatus => {
           
          if (trackStatus.textContent === result.status) {
            trackStatus.parentElement.classList.add("active");
          }
      });
     
      $("#ordertracking").html(orderinfo); 
        }
      });

    }) 

  })

// history
    $('.history').click(function(){

      $.get("/../laundry/customer/order.track.php", function(data) {
  
        let orderinfo = "";

        let filterData = data.filter(result => result.status === "Completed");

        if(filterData.length < 3){
          $("#history").css("height", "50vh");
        }        

          data.forEach(result => {
  
          if(result.status === "Completed"){
                orderinfo += `
                <br> Order Id: ${result.service_id} <br>
                Service: ${result.service} <br>
                Total kilos: ${result.kilos} <br>
                Paid amount: ${result.paid} <br>
                Status: ${result.status} <br>
            `;
      
            $("#prevOrders").html(orderinfo);

          }else{
            $("#prevOrders").html("No previous order");
          }
  
          });
        }) 
     })

})
