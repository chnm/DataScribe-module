document.addEventListener('DOMContentLoaded', e => {

const mediaSelect = document.getElementById('media-select');
const mediaPageInput = document.getElementById('media-page');
const previousButton = document.getElementById('media-previous');
const nextButton = document.getElementById('media-next');
const panzoomContainer = document.getElementById('panzoom-container');
const panzoomElem = document.getElementById('panzoom');
const panzoomImg = document.getElementById('panzoom-img');
const zoomInButton = document.getElementById('panzoom-zoom-in');
const zoomOutButton = document.getElementById('panzoom-zoom-out');
const rotateLeftButton = document.getElementById('panzoom-rotate-left');
const rotateRightButton = document.getElementById('panzoom-rotate-right');
const resetButton = document.getElementById('panzoom-reset');

let panzoom;
let rotateDeg = 0;
let state = {panzoom: {}, rotate: {}, src: null};

initMediaViewer();

// Handle media change.
mediaSelect.addEventListener('change', e => {
    gotoPage(mediaSelect.selectedIndex + 1);
});
// Handle page input enter key.
mediaPageInput.addEventListener('keydown', e => {
    if (13 === e.keyCode) {
        gotoPage(mediaPageInput.value);
    }
});
// Handle page input change.
mediaPageInput.addEventListener('change', e => {
    gotoPage(mediaPageInput.value);
});
// Handle the previous button.
previousButton.addEventListener('click', e => {
    gotoPage(mediaSelect.selectedIndex);
});
// Handle the next button.
nextButton.addEventListener('click', e => {
    gotoPage(mediaSelect.selectedIndex + 2);
});
// Handle the scroll wheel.
panzoomContainer.addEventListener('wheel', panzoom.zoomWithWheel);
// Handle the zoom in button.
zoomInButton.addEventListener('click', panzoom.zoomIn);
// Handle the zoom out button.
zoomOutButton.addEventListener('click', panzoom.zoomOut);
// Handle the reset button.
resetButton.addEventListener('click', e => {
    panzoom.reset();
    resetRotate();
    // Delete the current image's state.
    delete state.panzoom[panzoomImg.src];
    delete state.rotate[panzoomImg.src];
});
// Handle the rotate left button.
rotateLeftButton.addEventListener('click', e => {
    rotateDeg = rotateDeg - 90;
    panzoomImg.style.transition = 'transform 0.25s';
    panzoomImg.style.transform = `rotate(${rotateDeg}deg)`;
    state.rotate[panzoomImg.src] = panzoomImg.style.transform;
});
// Handle the rotate right button.
rotateRightButton.addEventListener('click', e => {
    rotateDeg = rotateDeg + 90;
    panzoomImg.style.transition = 'transform 0.25s';
    panzoomImg.style.transform = `rotate(${rotateDeg}deg)`;
    state.rotate[panzoomImg.src] = panzoomImg.style.transform;
});
// Set panzoom state on change.
panzoomElem.addEventListener('panzoomchange', (event) => {
    state.panzoom[panzoomImg.src] = event.detail;
});

// Initialize the media viewer.
function initMediaViewer() {
    panzoom = Panzoom(panzoomElem, {});
    if (1 < mediaSelect.options.length) {
        // There is more than one page.
        mediaPageInput.disabled = false;
        nextButton.disabled = false;
    }
}
// Go to a page.
function gotoPage(page) {
    if (mediaSelect.options.length < page || 1 > page) {
        // The page is invalid. Reset the pagination.
        page = 1;
    }
    if (1 === page) {
        previousButton.disabled = true;
    }
    if (1 < page) {
        previousButton.disabled = false;
    }
    if (mediaSelect.options.length === page) {
        nextButton.disabled = true;
    }
    if (mediaSelect.options.length > page) {
        nextButton.disabled = false;
    }
    mediaSelect.selectedIndex = page - 1;
    mediaPageInput.value = page;
    panzoomImg.src = mediaSelect.value;
    applyState();
}
// Reset rotation.
function resetRotate() {
    // Must set transition to none to prevent the image from unwinding when
    // rotating back to 0deg.
    rotateDeg = 0;
    panzoomImg.style.transition = 'none';
    panzoomImg.style.transform = 'none';
}
// Apply panzoom and rotate state for the current image.
function applyState() {
    let panzoomState = state.panzoom[panzoomImg.src];
    let rotateState = state.rotate[panzoomImg.src];

    if (panzoomState) {
        panzoom.reset({
            startScale: panzoomState.scale,
            startX: panzoomState.x,
            startY: panzoomState.y
        });
    } else {
        panzoom.reset();
    }
    if (rotateState) {
        panzoomImg.style.transform = rotateState;
    } else {
        resetRotate();
    }
}

});
