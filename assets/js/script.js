document.addEventListener("click", (e) => {
    if (e.target.classList.contains("bi-heart")) {
        e.target.style.display = "none";
        e.target.nextElementSibling.style.display = "inline-block";
    }
    
    if (e.target.classList.contains("bi-heart-fill")) {
        e.target.style.display = "none";
        e.target.previousElementSibling.style.display = "inline-block";
    }
});