//initial set up
//first find where we add data and then get said data from favoriteFood.json

let menuSection = document.getElementById("menu");
fetch('data/favoriteFood.json')
    .then(response => response.json())
    .then(data => {
        var html = "";
        //loop through each menu item and add data to table 
        for (let i = 0; i < data.menu.length; ++i) 
        {
            html += 
            `
            <tr>
                <td>${data.menu[i].name}</td>
                <td><img src="${data.menu[i].image}" alt="${data.menu[i].name}  "></td>
                <td>$${data.menu[i].price}</td>
                <td>Contains: ${data.menu[i].ingredients}</td>
                <td>${data.menu[i].description}</td>
                <td>${data.menu[i].category}</td>
                <td>${data.menu[i].cuisine}</td>
            </tr>
            `;
        }
        //update html with table
        menuSection.innerHTML = html;
    })
    .catch(error => console.error('Error:', error));


/*
* Effectively Serves as a Scroll Event Listener for funsies
*/
window.addEventListener('scroll', function() {
    const navbar = document.querySelector("nav");
    navbar.classList.add('navbar-dimmed');
    console.log("Navbar dimmed");
});

window.addEventListener("scrollend", (event) => {
    const navbar = document.querySelector("nav");
    navbar.classList.remove('navbar-dimmed');
});

