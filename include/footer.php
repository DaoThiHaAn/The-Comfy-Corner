<?php
$address = "268, Ly Thuong Kiet Street, District 10, Ho Chi Minh City, Vietnam";
$encodedAddress = urlencode($address); // Encode the address for use in a URL
$googleMapsUrl = "https://www.google.com/maps/search/?api=1&query=" . $encodedAddress;
?>

<footer>
    <i class="fa-solid fa-shop icon"></i>

    <div class="footer-content">
        <p>&copy; 2025 &nbsp; <i>The Comfy Corner.</i>&nbsp; All rights reserved.</p>
        <p>Store location: 
            <a href="<?php echo $googleMapsUrl; ?>" target="_blank">
                <?php echo $address; ?>
            </a>
        </p>
        
        <div class="footer-contact">
            <p>Contact us: <span class="tel"> +84 914565109 </span></p>
            <p>Email: <a href="mailto:daothihaan@gmail.com">daothihaan@gmail.com</a></p>
        </div>

        <div class="footer-social">
            <p>Follow us:</p>
            <a href="https://www.facebook.com" target="_blank">
                <img src="<?=$_SESSION['base_url']?>images/fb-icon.png" alt="Facebook">
            </a>
        </div>
    </div>
</footer>
