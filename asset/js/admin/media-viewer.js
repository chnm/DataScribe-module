document.addEventListener('DOMContentLoaded', e => {

const mediaSelect            = document.getElementById('media-select');
const mediaPageInput         = document.getElementById('media-page');
const previousButton         = document.getElementById('media-previous');
const nextButton             = document.getElementById('media-next');
const panzoomContainer       = document.getElementById('panzoom-container');
const panzoomElem            = document.getElementById('panzoom');
const panzoomImg             = document.getElementById('panzoom-img');
const zoomInButton           = document.getElementById('panzoom-zoom-in');
const zoomOutButton          = document.getElementById('panzoom-zoom-out');
const rotateLeftButton       = document.getElementById('panzoom-rotate-left');
const rotateRightButton      = document.getElementById('panzoom-rotate-right');
const resetButton            = document.getElementById('panzoom-reset');
const fullscreenButton       = document.getElementById('fullscreen');
const deleteButton           = document.getElementById('delete-button');
const horizontalLayoutButton = document.getElementById('horizontal-layout');
const verticalLayoutButton   = document.getElementById('vertical-layout');

let panzoom;
let state;
let rotateDeg;

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
// Handle panzoom click to focus.
panzoomContainer.addEventListener('click', e => {
    panzoomContainer.focus();
});
// Handle panning by arrow keys.
panzoomContainer.addEventListener('keydown', e => {
    switch (e.code) {
        case 'ArrowUp':
            panzoom.pan(0, -2, {relative: true});
            break;
        case 'ArrowDown':
            panzoom.pan(0, 2, {relative: true});
            break;
        case 'ArrowLeft':
            panzoom.pan(-2, 0, {relative: true});
            break;
        case 'ArrowRight':
            panzoom.pan(2, 0, {relative: true});
            break;
        default:
            return;
    }
    e.preventDefault();
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
    saveState();
});
// Handle the rotate left button.
rotateLeftButton.addEventListener('click', e => {
    rotateDeg = rotateDeg - 90;
    panzoomImg.style.transition = 'transform 0.25s';
    panzoomImg.style.transform = `rotate(${rotateDeg}deg)`;
    state.rotate[panzoomImg.src] = rotateDeg;
    saveState();
});
// Handle the rotate right button.
rotateRightButton.addEventListener('click', e => {
    rotateDeg = rotateDeg + 90;
    panzoomImg.style.transition = 'transform 0.25s';
    panzoomImg.style.transform = `rotate(${rotateDeg}deg)`;
    state.rotate[panzoomImg.src] = rotateDeg;
    saveState();
});
// Handle the fullscreen (focus) button.
fullscreenButton.addEventListener('click', e => {
    const body = document.querySelector('body');
    if (body.classList.contains('fullscreen')) {
        disableFullscreen();
    } else {
        enableFullscreen();
    }
    state.fullscreen[panzoomImg.src] = body.classList.contains('fullscreen');
    saveState();
});
// Handle the horizontal layout button.
horizontalLayoutButton.addEventListener('click', e => {
    enableHorizontalLayout();
    state.layout[panzoomImg.src] = 'horizontal';
    saveState();
});
// Handle the vertical layout button.
verticalLayoutButton.addEventListener('click', e => {
    enableVerticalLayout();
    state.layout[panzoomImg.src] = 'vertical';
    saveState();
});
// Set panzoom state on change.
panzoomElem.addEventListener('panzoomchange', (event) => {
    state.panzoom[panzoomImg.src] = event.detail;
    saveState();
});
// Set the state in local storage on form submit.
document.getElementById('record-form').addEventListener('submit', e => {
    saveState();
});

// Initialize the media viewer.
function initMediaViewer() {
    rotateDeg = 0
    panzoom = Panzoom(panzoomElem, {});
    if (1 < mediaSelect.options.length) {
        // There is more than one page.
        mediaPageInput.disabled = false;
        nextButton.disabled = false;
    }
    // Get the state from local storage and go to the saved page, if any.
    state = JSON.parse(localStorage.getItem('datascribe_media_viewer_state'));
    if (null === state) {
        state = {
            panzoom: {},
            rotate: {},
            fullscreen: {},
            layout: {},
            src: null
        };
        saveState();
    }
    if (state.src) {
        let option = mediaSelect.querySelector(`[value="${state.src}"]`);
        if (option) {
            option.selected = true;
        } else {
            state.src = null;
            saveState();
        }
    }
    gotoPage(mediaSelect.selectedIndex + 1)
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
    state.src = mediaSelect.value;
    saveState();
    applyState();
}
// Reset rotation.
function resetRotate() {
    rotateDeg = 0;
    panzoomImg.style.transition = 'none';
    panzoomImg.style.transform = 'none';
}
// Enable fullscreen.
function enableFullscreen() {
    document.querySelector('body').classList.add('fullscreen');
    document.querySelector('.sidebar').style.display = 'none';
    fullscreenButton.textContent = Omeka.jsTranslate('Disable focus mode');
    if (deleteButton) {
        deleteButton.style.display = 'none';
    }
}
// Disable fullscreen.
function disableFullscreen() {
    document.querySelector('body').classList.remove('fullscreen');
    document.querySelector('.sidebar').style.display = '';
    fullscreenButton.textContent = Omeka.jsTranslate('Enable focus mode');
    if (deleteButton) {
        deleteButton.style.display = '';
    }
}
// Enable horizontal layout.
function enableHorizontalLayout() {
    const currentRow = document.querySelector('.current-row');
    verticalLayoutButton.classList.remove('active');
    verticalLayoutButton.disabled = false;
    horizontalLayoutButton.classList.add('active');
    horizontalLayoutButton.disabled = true;
    currentRow.classList.add('horizontal');
    currentRow.classList.remove('vertical');
}
// Enable vertical layout.
function enableVerticalLayout() {
    const currentRow = document.querySelector('.current-row');
    verticalLayoutButton.classList.add('active');
    verticalLayoutButton.disabled = true;
    horizontalLayoutButton.classList.remove('active');
    horizontalLayoutButton.disabled = false;
    currentRow.classList.remove('horizontal');
    currentRow.classList.add('vertical');
}
// Apply panzoom and rotate state for the current image.
function applyState() {
    let panzoomState = state.panzoom[panzoomImg.src];
    let rotateState = state.rotate[panzoomImg.src];
    let fullscreenState = state.fullscreen[panzoomImg.src];
    let layoutState = state.layout[panzoomImg.src];
    if (panzoomState) {
        panzoom.zoom(panzoomState.scale);
        // Must use setTimeout() due to async nature of Panzoom.
        // @see https://github.com/timmywil/panzoom#a-note-on-the-async-nature-of-panzoom
        setTimeout(() => panzoom.pan(panzoomState.x, panzoomState.y))
    } else {
        panzoom.reset();
    }
    if (rotateState) {
        rotateDeg = rotateState;
        // Must set transition to none to prevent the image from unwinding when
        // rotating back to 0deg.
        panzoomImg.style.transition = 'none';
        panzoomImg.style.transform = `rotate(${rotateState}deg)`;
    } else {
        resetRotate();
    }
    if (fullscreenState) {
        enableFullscreen();
    } else {
        disableFullscreen();
    }
    if ('vertical' === layoutState) {
        enableVerticalLayout();
    } else {
        enableHorizontalLayout();
    }
}
// Save the state to local storage.
function saveState() {
    localStorage.setItem('datascribe_media_viewer_state', JSON.stringify(state));
}

});
