let dropdowns = document.querySelectorAll('.dropdown-menu')
let dropdownLinks = document.querySelectorAll('.dropdown-toggle');

dropdownLinks.forEach((link, index) => link.addEventListener('click', () => {
    dropdowns[index].classList.toggle('active')
})) 