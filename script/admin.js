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
                tableBody += (key === "pick_up_time") ? `<td>${formatDate(value)}</td>` : `<td>${value}</td>`;
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
                <th>Service Id</th>
                <th>Customer Id</th>
                <th>Service</th>
                <th>Name</th>
                <th>Number</th>
                <th>Location</th>
                <th>Pickup</th>
                <th>Request</th>
                <th>Status</th>
                <th>Kilo or Piece</th>
                <th>Amount</th>
                <th>Paid</th>
            </tr>
        </thead>
    `;

    let tableHead2 = `
        <thead>
            <tr id="tablehead">
                <th>Service Id</th>
                <th>Service</th>
                <th>Name</th>
                <th>Number</th>
                <th>House Delivery</th>
                <th>Location</th>
                <th>Kilo/Piece</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Status</th>
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

    inventory

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

        console.log(tableBody);

        $('#table3').html(tablehead3 + tableBody);
    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });
})


// sales

    let walkinsAmount = 0;

    $.get("/../laundry/admin/sales.walkins.php",function(data) { 

        data.forEach(result => {
            walkinsAmount += Number(result.amount);

        });

        // $('#table3').html(tablehead3 + tableBody);

    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });

     let onlineAmount = 0;

    $.get("/../laundry/admin/sales.online.php",function(data) { 

        data.forEach(result => {
            onlineAmount += Number(result.amount);

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



