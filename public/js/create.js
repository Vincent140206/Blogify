const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('thumbnail');
    const previewImg = document.getElementById('thumbnail-preview-img');

    // Click upload area untuk buka file dialog
    uploadArea.addEventListener('click', () => fileInput.click());

    // Preview gambar saat pilih file
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewImg.classList.remove('default-icon'); 
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop style dan preview
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.backgroundColor = '#cfcfcf';
    });
    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.style.backgroundColor = '#e0e0e0';
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.backgroundColor = '#e0e0e0';
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fileInput.files = e.dataTransfer.files;
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewImg.classList.remove('default-icon');
            };
            reader.readAsDataURL(file);
        }
    });