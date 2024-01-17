function toggleGridLayout() {
    const grid = document.getElementById('grid');
    grid.classList.toggle('single-row-layout');
}

function adjustItemWidth() {
    const gridItems = document.querySelectorAll('.grid-item');
    gridItems.forEach(item => {
        item.classList.toggle('small-width');
    });
}

