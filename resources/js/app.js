const boutonMenu = document.getElementById('menu-toggle');
const menuMobile = document.getElementById('menu-mobile');

if (boutonMenu && menuMobile) {
    boutonMenu.addEventListener('click', function () {
        menuMobile.classList.toggle('hidden');
    });
}
