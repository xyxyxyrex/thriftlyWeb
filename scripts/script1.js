var storyArea = document.getElementById('storyArea');

function scrollStories(direction) {
    var scrollAmount = 200; // Adjust the scroll amount as needed

    if (direction === 'left') {
        storyArea.scrollLeft -= scrollAmount;
    } else if (direction === 'right') {
        storyArea.scrollLeft += scrollAmount;
    }
}

function toggleNavMenu() {
            var navTwoLeft = document.querySelector('.navBar2');
            navTwoLeft.classList.toggle('active');
        }