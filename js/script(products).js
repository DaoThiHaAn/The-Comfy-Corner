var filtersort = document.querySelector(".filter-sort");
var filtericon = document.querySelector(".filter-icon");


// toggle sort and filter screen in responsive mode
document.getElementById("filter-icon").addEventListener("click", function() {
    // Toggle visibility
    filtersort.classList.toggle("active");
    filtericon.classList.toggle("active");

    filtericon.style.left = filtersort.offsetWidth + "px";
    var img = document.querySelector(".filter-icon img");
    if (img.src.includes("funnel.png")) {
        img.src = base_url + "images/filter-close.png";
        img.style.width = "20px";
    } else {
        img.src = base_url + "images/funnel.png";
        filtericon.style.left = "0";
    }
})

// AJAX live search
const searchInput = document.getElementById("search-input");
const suggestionBox = document.getElementById("suggestion-box");

let suggestions = [];
let selectedIndex = -1;

searchInput.addEventListener("input", function() {
    const query = this.value.trim().toLowerCase();

    if (query.length === 0) {
        suggestionBox.innerHTML = "";
        suggestionBox.style.display = "none";
        return;
    }

    fetch(`search_products.php?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            suggestions = data;
            suggestionBox.innerHTML = "";
            selectedIndex = -1;

            if (suggestions.length > 0) {
                suggestions.forEach((item, index) => {
                    const div = document.createElement("div");
                    div.classList.add("suggestion-item");
                    div.textContent = item;
                    div.dataset.index = index;
                    div.onclick = () => selectSuggestion(index);
                    suggestionBox.appendChild(div);
                });
                suggestionBox.style.display = "block";
            } else {
                suggestionBox.style.display = "none";
            }
        });
});

// Select suggestion by clicking
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const suggestionBox = document.getElementById("suggestion-box");

    searchInput.addEventListener("input", function() {
        const query = searchInput.value.trim();

        // If query is empty, clear suggestions
        if(query.length === 0) {
            suggestionBox.innerHTML = "";
            return;
        }

        fetch("pages/search_products.php?q=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                suggestionBox.innerHTML = data;
            })
            .catch(error => {
                console.error("Error fetching suggestions:", error);
            });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const livesearchBox = document.getElementById("livesearch-box");

    window.showResults = function(query) {
        // If query is empty, clear suggestions
        if(query.trim().length === 0) {
            livesearchBox.innerHTML = "";
            return;
        }

        // Fetch suggestions from search_products.php with parameter q
        fetch("pages/search_products.php?q=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                livesearchBox.innerHTML = html;
            })
            .catch(error => {
                console.error("Error fetching live search suggestions:", error);
                livesearchBox.innerHTML = "";
            });
    }
});