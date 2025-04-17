console.log("script.js loaded");

const homeicon = document.getElementById("homeicon");
var navbar = document.getElementById("navbar")


document.getElementById("homebtn").addEventListener("mouseover", () => {
    homeicon.src = base_url + "images/home-hover.png";
});

document.getElementById("homebtn").addEventListener("mouseout", () => {
    if (!window.location.href.includes("page=home")) {
        homeicon.src = base_url + "images/home.png";
    }
});

function openMenu() {
    var menuicon = document.querySelector(".openmenu img")
    if (navbar.classList.contains("responsive")) {
        navbar.classList.remove("responsive");
        menuicon.src = base_url + "images/list-view.png";
    } else {
        navbar.classList.add("responsive");
        menuicon.src = base_url + "images/close.png";
    }
}

function openDropdown() {
    var dropdown = document.getElementsByClassName("dropbtn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdwnContent = this.nextElementSibling;
            if (dropdwnContent.style.display === "block") {
                dropdwnContent.style.display = "none";
            } else {
                dropdwnContent.style.display = "block";
            }
        });
    }
}

let topbtn = document.getElementById("topbtn");
window.addEventListener("scroll", function() {
    if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
        topbtn.style.display = "block";

    } else {
        topbtn.style.display = "none";
    }
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        navbar.classList.add("scrolled");

    } else {
        navbar.classList.remove("scrolled");
    }

});


function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

document.addEventListener("DOMContentLoaded", function() {
    openDropdown();
});


//Adjust top-margin of main content
function adjustMarginTop() {
    const navbar = document.getElementById("navbar");
    const content = document.querySelector("main"); // Adjust based on your layout
    if (navbar && content) {
        let navbarHeight = navbar.offsetHeight; 
        content.style.marginTop = navbarHeight + "px";
    }
}

// Run on page load and when resizing window
window.onload = adjustMarginTop;
window.onresize = adjustMarginTop;

function openDialog(contents, header = '') {
    if (header !== '') {
        let headerDiv = document.querySelector('.dialog-header');
        headerDiv.textContent = header;
    }
    let contentDiv = document.querySelector('.content');
    contentDiv.innerHTML = '';

    contents.forEach(text => {
        let p = document.createElement('p');
        p.textContent = text;
        contentDiv.appendChild(p);
    });

    document.querySelector('.dialog-container').style.display = 'flex';
}

function closeDialog() {
    document.querySelector('.dialog-container').style.display = 'none';
}


function openLogoutDialog() {
    let contentDiv = document.querySelector('.dialog-body .content');
    let p = document.createElement('p');
    p.textContent = 'Are you sure to logout? 😟';
    contentDiv.innerHTML = p.outerHTML;
    document.querySelector('.dialog').style.width = '25%';
    document.querySelector('.ok-btn').onclick = confirmLogout;
    document.querySelector('.cancel-btn').style.display = 'block';
    document.querySelector('.dialog-container').style.display = 'flex';
}

function confirmLogout() {
    document.querySelector('.dialog-container').style.display = 'none';
    window.location.href = "index.php?page=logout";
}

function openDeleteDialog() {
    let contentDiv = document.querySelector('.dialog-body .content');
    let p = document.createElement('p');
    p.innerHTML = 'Are you sure to delete your account?<br>You can\'t undo this action! 😟';
    contentDiv.innerHTML = p.outerHTML;
    document.querySelector('.dialog').style.width = '25%';
    document.querySelector('.ok-btn').onclick = confirmDelete;
    document.querySelector('.cancel-btn').style.display = 'block';
    document.querySelector('.dialog-container').style.display = 'flex';
}

function confirmDelete() {
    document.querySelector('.dialog-container').style.display = 'none';
    window.location.href = "index.php?page=delete_account";
}

function openLoginRequiredDialog() {
    let header = document.querySelector('.dialog-header');
    header.textContent = 'Login Required!';
    let contentDiv = document.querySelector('.dialog-body .content');
    let p = document.createElement('p');
    p.innerHTML = 'Log in to add this product to your cart.<br>Please log in to continue.';
    contentDiv.innerHTML = p.outerHTML;
    document.querySelector('.dialog').style.width = '25%';
    document.querySelector('.signin-btn-dialog').style.display = 'block';
    document.querySelector('.ok-btn').style.display = 'none';
    document.querySelector('.cancel-btn').style.display = 'block';
    document.querySelector('.dialog-container').style.display = 'flex';
}
