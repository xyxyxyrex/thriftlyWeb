function openFileExplorer() {
    document.getElementById('fileInput').click();
}

function displayFileName() {
    const fileInput = document.getElementById('fileInput');
    const thumbnailContainer = document.querySelector('.fa-circle-plus');
    const thumbnail = document.createElement('img');

    thumbnail.classList.add('thumbnail');

    const file = fileInput.files[0];

    if (file) {
        thumbnail.src = URL.createObjectURL(file);
        thumbnailContainer.innerHTML = '';
        thumbnailContainer.appendChild(thumbnail);
    }
}

function submitPost() {
    document.querySelector('form').submit();
    return false;
}