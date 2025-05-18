$(function(){

    //buttons
    $('#online').show();

    $('.navtwobtns').click(function() {

        $('.navtwobtns').removeClass('active'); 
        $(this).addClass('active');
        
        $('.tab').hide();
        
       let targetForm = $(this).data('target');
       $(targetForm).show();
    
    });

    // online boooking

    $('#update-btn').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });
    $('#update-btn2').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });
    
    

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

    // walkins
    
    function fetchData(path, tableHead, htmlTag) {

    $.get(path,function(data) {
        
        let tableBody = "<tbody>";

       data.forEach(result => {
        tableBody += "<tr>";
            Object.entries(result).forEach(([key, value]) => {
                if (key === "pick_up_time") {
                    tableBody += `<td>${formatDate(value)}</td>`;
                } else if (key === "completed_at") {
                    // Check if completed_at is null, and replace it with "processing"
                    tableBody += (value === null) ? `<td>Processing</td>` : `<td>${formatDate(value)}</td>`;
                } else {
                    tableBody += `<td>${value}</td>`;
                }
            });
        tableBody += "</tr>";
});


        tableBody += "</tbody>";

        $(htmlTag).html(tableHead + tableBody);
    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });
    }

    let tableHead = `
        <thead>
            <tr id="tablehead">
                <th>LAUNDRY NO.</th>
                <th>CUS NO.</th>
                <th>LAUNDRY</th>
                <th>NAME</th>
                <th>PHONE</th>
                <th>Location</th>
                <th>P.TIME</th>
                <th>REQUEST</th>
                <th>STATUS</th>
                <th>KILO/PIECE</th>
                <th>AMOUNT</th>
                <th>PAID</th>
                <th>COMPLETED</th>
            </tr>
        </thead>
    `;

    let tableHead2 = `
        <thead>
            <tr id="tablehead">
                <th>CUSTOMER NO.</th>
                <th>LAUNDRY</th>
                <th>NAME</th>
                <th>PHONE</th>
                <th>DELIVERY</th>
                <th>LOCATION</th>
                <th>KILO/PIECE</th>
                <th>AMOUNT</th>
                <th>PAID</th>
                <th>STATUS</th>
                <th>COMPLETED</th>
            </tr>
        </thead>
    `;

    fetchData("/../laundry/admin/online.admin.php", tableHead, "#table");
    fetchData("/../laundry/admin/walkins.get.admin.php", tableHead2, "#table2");
    
    
    // setInterval(fetchData, 1000);

    $('#addwalkins').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });

   // inventory

$('.inv-nav').click(function(){

    let tablehead3 = `
        <thead>
            <tr id="tablehead">
                <th>Laundry basket</th>
                <th>Hanger</th>
                <th>Scatch tape</th>
                <th>Plastic</th>
                <th>Soap Powder</th>
                <th>Fabcon</th>
                <th>Zonrox</th>
                <th>Check by</th>
                <th>Note</th>
                <th>Date</th>
            </tr>
        </thead>
    `;
   
$.get("/../laundry/admin/inventory.get.php",function(data) {
        
        let tableBody = "<tbody>";

        data.forEach(result => {
     
            tableBody += "<tr>";
            Object.values(result).forEach(value => {
                tableBody += `<td>${value}</td>`;
                console.log(value);
            })
            tableBody += "</tr>";
        });

        tableBody += "</tbody>";

        $('#table3').html(tablehead3 + tableBody);
    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });
})

 $('#inv-update-btn').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });


// sales

    // buttons
    $('#sales-table').show();

    $('.sales-nav-btn').click(function() {

        $('.sales-nav-btn').removeClass('active'); 
        $(this).addClass('active');
        
        $('.sales-expenses').hide();
        
       let targetForm = $(this).data('target');
       $(targetForm).show();
    
    });

     $('#exp-update-btn').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });

    let walkinsAmount = 0;

    $.get("/../laundry/admin/sales.walkins.php",function(data) { 

        data.forEach(result => {

            if(result.status == "Completed"){
                walkinsAmount += Number(result.amount);
            }

        });

        // $('#table3').html(tablehead3 + tableBody);

    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });

     let onlineAmount = 0;

    $.get("/../laundry/admin/sales.online.php",function(data) { 

        data.forEach(result => {
            if(result.status === "Completed"){
                 onlineAmount += Number(result.amount);
            }
        });
        // $('#table3').html(tablehead3 + tableBody);

    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Online', 'Walk-ins'],
          ['May', onlineAmount, walkinsAmount],
        //   ['Feb',  1170,      460],
        //   ['March',  660,       1120],
        //   ['April',  1030,      540],
        //   ['May',  1000,      400],
        //   ['June',  1170,      460],
        //   ['July',  660,       1120],
        //   ['August',  1030,      540],
        //   ['Sept',  1170,      460],
        //   ['Oct',  660,       1120],
        //   ['Nov',  1030,      540],
        //   ['Dec',  660,       1120]
        ]);

       var options = {
        title: "Enerbubbles Sales",
        width: 900,
        height: 500,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

        var chart = new google.visualization.BarChart(document.getElementById('chart'));

        chart.draw(data, options);
      }

});



