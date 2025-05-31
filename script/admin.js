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

    let totalSales = 0;
    
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
                }
                else {
                    tableBody += `<td>${value}</td>`;
                }
            });
        tableBody += "</tr>";

        if(result.completed_at){
            totalSales += Number(result.amount);
        }
        
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

    $('#sales-table').show();

    $('.sales-nav-btn').click(function() {

        $('.sales-nav-btn').removeClass('active'); 
        $(this).addClass('active');
        
        $('.sales-expenses').hide();
        
       let targetForm = $(this).data('target');
       $('#expenses-form').hide();

       $(targetForm).show();
    
    });

     $('#exp-update-btn').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });



    // inventory and gross sales update, use post method to update the sales then display the 
    // the sales using table

    //  let tablehead4 = `
    //     <thead>
    //         <tr id="tablehead">
    //             <th>Month-Year</th>
    //             <th>Online sales</th>
    //             <th>Walkins sales</th>
    //             <th>Gross income</th>
    //             <th>Expenses</th>
    //             <th>Net income</th>
    //         </tr>
    //     </thead>
    // `;
    
    // $.get("/../laundry/admin/sales.get.php",function(data) { 

    // data.forEach(result => {

    //     let monthYear = result.month_year;
    //     let gross_income = Number(result.gross_income);
    //     let expenses = Number(result.expenses);
    //     let netIncome = Number(result.net_income);


 let tablehead5 = `
        <thead>
            <tr id="tablehead">
                <th>Month-Year</th>
                <th>ELECTRICITY</th>
                <th>WATER</th>
                <th>LABOR</th>
                <th>STOCKS</th>
                <th>OTHER EXPENSES</th>
                <th>TOTAL EXPENSES</th>
            </tr>
        </thead>
    `;
 let totalExpenses = 0;
  
        $.get("/../laundry/admin/expenses.get.php",function(data) {
        
        let tableBody = "<tbody>";

        data.forEach(result => {
     
            tableBody += "<tr>"
            Object.values(result).forEach(value => {
                tableBody += `<td>${value}</td>`;
            })
            tableBody += "</tr>";
            
             totalExpenses += result.total_expenses;
        });

        tableBody += "</tbody>";

        $('#table5').html(tablehead5 + tableBody);
    }).fail(function() {
        console.error("Error: Unable to fetch data.");
    });

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        let netIncome = Number(totalSales) - Number(totalExpenses);
        
        var data = google.visualization.arrayToDataTable([
          ['Month-Year','Gross Income', 'Total Expenses', 'Net Income'],
          ['May-2025', totalSales, totalExpenses, netIncome],
      
        ]);


       var options = {
        title: "Enerbubbles Sales",
        width: 900,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

        var chart = new google.visualization.BarChart(document.getElementById('chart'));

        chart.draw(data, options);
      }
    
    //   let tableBody = "<tbody>";
     
    //         tableBody += "<tr>";
    //         Object.values(result).forEach(value => {
    //             tableBody += `<td>${value}</td>`;
    //         })
    //         tableBody += "</tr>";
   
    //     tableBody += "</tbody>";

    //     $('#table4').html(tablehead4 + tableBody);

    // });

    // }).fail(function() {
    //     console.error("Error: Unable to fetch data.");
    // });

    
    // message

     $('#message-btn').on('click', function() {
        let targetdiv = $(this).data('target');
        $(targetdiv).toggle();
    });

});



