// js/main.js
// Interactive Frontend Features: Dynamic Filtering, Smooth Scroll, Real-time Validation

document.addEventListener("DOMContentLoaded", () => {
    
    // Feature 1: Dynamic Recipe Search & Category Filter (DOM Manipulation)
    const searchInput = document.getElementById("recipeSearch");
    const filterButtons = document.querySelectorAll(".filter-btn");
    const recipeCards = document.querySelectorAll(".recipe-item");

    function filterRecipes() {
        const query = searchInput ? searchInput.value.toLowerCase() : "";
        const activeBtn = document.querySelector(".filter-btn.active");
        const selectedCategory = activeBtn ? activeBtn.getAttribute("data-category") : "all";

        recipeCards.forEach(card => {
            const title = card.getAttribute("data-title").toLowerCase();
            const category = card.getAttribute("data-category");

            const matchesQuery = title.includes(query);
            const matchesCategory = (selectedCategory === "all" || category === selectedCategory);

            if (matchesQuery && matchesCategory) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", filterRecipes);
    }

    if (filterButtons.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                filterButtons.forEach(b => b.classList.remove("active", "btn-dark"));
                filterButtons.forEach(b => b.classList.add("btn-outline-dark"));
                
                btn.classList.add("active", "btn-dark");
                btn.classList.remove("btn-outline-dark");
                
                filterRecipes();
            });
        });
    }

    // Feature 2: Smooth Scrolling for Navigation Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });
    });

    // Feature 3: Client-side Form Validation
    const clientForms = document.querySelectorAll(".needs-validation-js");
    clientForms.forEach(form => {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    });
});
