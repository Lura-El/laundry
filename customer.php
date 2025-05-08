<?php
     htmlspecialchars(include './customer/getcontact.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/customer.css">
    <script src="https://kit.fontawesome.com/812680a24a.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <script src="./script/customer.js" defer></script>
    <title>Laundry</title>
</head>
<body>
<!-- home page -->
    <header>
        <nav id="topnav">
            <div></div>
            <div class="btns">
                <form action="forms/logout.php">
                    <button class="navButton" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>
        </nav>  
        <div class="headercon">
            <div id="logo">
                <h1 id="brand">ENERBUBBLES</h1>
                <span id="brandtwo">LAUNDRY STATION</span>
            </div>
            <div class="info">
                <p><i class="fa-solid fa-phone"></i> 0908-892-3842</p>
                <p><i class="fa-solid fa-clock"></i> Mon-Sun 7:00AM - 7:00PM</p>
                <p><i class="fa-solid fa-location-dot"></i> Blk 1 Lot 38 Phase 3, Mainroad Ave.,
                Maryjomes Subd. Molino 4, Bacoor Cavite</p>
            </div>
            <div class="info sched">
                <button>SCHEDULE PICK-UP</button>
            </div>
        </div>
<!-- second nav -->
        <div id="customer-tab">
            <button class="navtwobtns active service" data-target="#servicepricetab">SERVICES & PRICING</button>
            <button class="navtwobtns" data-target="#booking">BOOK A SERVICE</button>
            <button class="navtwobtns track" data-target="#trackorder">TRACK ORDER</button>
            <button class="navtwobtns history" data-target="#history">HISTORY</button>
            <button class="navtwobtns" data-target="#messageus">MESSAGE US</button>
        </div>
    </header>

<!-- service and pricing  -->
<div id="servicepricetab" class="tab">
    <h3>5-in-1 service for as low as 25 pesos per kilo</h3>
    <div id="flowimg">
        <div class="img">
            <img src="photos/pickup.png" alt="pick up"><div class="tag">Pick-up</div>
            <div class="description">After scheduling a service. Please wait for confirmation, we will reach out to you A.S.A.P.</div>
        </div>
        <div class="img">
            <img src="photos/washing.png" alt="wash"><div class="tag">Wash</div>
            <div class="description">Every piece of clothing is handled with love and care. Before placing them in the machine,
                we carefully sort them based on their category to ensure proper washing
           </div>
        </div>
        <div class="img">
            <img src="photos/dry.png" alt="dry"><div class="tag">Dry</div>
            <div class="description">We use the air-dry technique to dry clothes—a time-honored and eco-friendly
                 method that preserves fabric quality while ensuring lasting freshness.
            </div>
        </div>
        <div class="img">
            <img src="photos/folded.png" alt="fold"><div class="tag">Fold</div>
            <div class="description">We gently fold each piece of clothing by hand, carefully inspecting the quality of 
                our washing to ensure freshness and perfection in every garment.
            </div>
        </div>
        <div  class="img">
            <img src="photos/deliver.png" alt="delivery"><div class="tag">Deliver</div>
            <div class="description">We value transparency and efficiency. Our streamlined process, powered by our tracking system,
                 ensures smooth operations while keeping you informed every step of the way especially during the final phase: delivery.
            </div>
        </div>
     </div>

     <div  id="note">
        Note: <span>Free pick up and delivery for 10kls and above. 
            If less than 10kls, you will be charged equivalent to 10kls as a charge for pick up and delivery. 
        </span>
     </div>

     <h2>services and prices</h2>
     <div id="con-serv-n-price">
        <div>
            <p>Regular wash - 25</p>
            <p>Special wash - 60</p>
            <p>Seatcover - 60 </p> 
            <p>White and Baby clothes - 50</p>
            <p>Curtains - 50 </p>
            <p>Blankets - 45</p>
        </div>
        <div>
            <p>Large items - 45</p>
            <p>Jackets - 130</p>
            <p>Trouser and slacks -130</p>
            <p>Barong jusi - 120 per piece</p>
            <p>Barong pina - 150 per piece</p>
            <p>Small gown -180 per piece</p>
        </div>
        <div>
            <p>Suit - 200 pair</p>
            <p>Simple gown - 200 per piece</p>
            <p>Special gown - 300 per piece</p>
            <p>Leather - 300 per piece</p>
            <p>Wedding gown 500 per piece</p>
            <p>Wedding gown set - 800</p>
        </div>
     </div>

</div>

<!-- bookingtab-->
<div id="booking" class="tab">

    <div id="contact-info" ></div>

    <!-- default address -->
    <div id="defaultcontact">
        <?php 
            echo "<div>" . htmlspecialchars($name).  "</div>";
            echo "<div>" . htmlspecialchars($number).  "</div>";
            echo "<div>" . htmlspecialchars($location).  "</div>";
        ?>
    <div>
        </div>
        <button id="edit" data-target="#defcon-form">edit</button>
    </div>

    <!-- default address form -->
        <form action="customer/default.php" method="POST" id="defcon-form">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="c-info input" required>
            </div>
            <div>
                <label for="number">Number:</label>
                <input type="tel" name="number" id="number" class="c-info input" required>
            </div>
            <div>
                <label for="location">Location:</label>
                <input type="text" max="200" name="location" id="location" class="c-info input" required>
            </div>
            <button type="submit" id="setdefault">SET DEFAULT</button>
        </form>
    
    <!-- booking form -->
        <form action="customer/book.php" method="POST">
            <label for="laundry"></label> <br>
            <select name="services" id="services" required>
                <option value="">Select Service</option>
                <option value="regularwash">Regular(wash-dry-fold)</option>
                <option value="specialwash">Special Wash(w/ press)</option>
                <option value="whitebaby">White or Baby Clothes</option>
                <option value="comforters">Comforters </option>
                <option value="blankets">Blankets, Towels, Sweaters</option>
                <option value="largeitems">Large Items</option>
                <option value="curtains">Curtains</option>
                <option value="seatcovers">Seat Covers</option>
                <option value="barongpina">Barong(Pina)</option>
                <option value="barongjusi">Barong(Jusi)</option>
                <option value="suit">Suit</option>
                <option value="trouserslacks">Trouser/Slacks</option>
                <option value="weddinggown">Wedding Gown</option>
                <option value="weddinggownsets">Wedding Gown Sets</option>
                <option value="simplegown">Simple Gown</option>
                <option value="specialgown">Special Gown</option>
                <option value="smallgown">Small Gown</option>
                <option value="jackets">Jackets</option>
                <option value="leather">Leather Items</option>
            </select> 
            <div>
                <label for="time"><Pick-up></Pick-up>Pick-up time</label>
                <input type="datetime-local" name="datetime" value="07:00" id="time" class="c-info input" required>
            </div>
            <div>
                <label for="specialrequest">Special Request:</label>
                <input type="text" name="specialrequest" id="specialrequest" class="c-info  input">
            </div>
            <button type="submit" id="submitbtn">PLACE ORDER</button>
        </form>
</div> 

<!-- track order -->
<div id="trackorder" class="tab">

<div id="trackvisual">

        <div class="line"></div>

        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">pending</p>
        </div>
        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">for pick up</p>
        </div>
        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">washing</p>
        </div>
        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">drying</p>
        </div>
        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">folding</p>
        </div>
        <div class="track-circle">
            <div class="track-id"></div>
            <div class="s-circle"></div>
            <p class="track-status">for delivery</p>
        </div>
    </div>

    <div id="ordertracking"></div>
    
</div>

<!-- history -->

<div id="history" class="tab">
    <div id="prevOrders"></div>
</div>

<!-- message us -->

<div id="message">
    
</div>
<footer>
    <div id="flow">Schedule a service ---> Get notify ---> Pick up ---> Track order ---> Deliver</div>
    <div>Message us any time. We are here for you.</div>
</footer>
</body>
</html>
